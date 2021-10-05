<?php

declare(strict_types=1);
/**
 * FAQ.
 */

namespace HDNET\Faq\Controller;

use HDNET\Faq\Domain\Model\QuestionCategory;
use HDNET\Faq\Domain\Repository\QuestionCategoryRepository;
use HDNET\Faq\Domain\Repository\QuestionRepository;
use HDNET\Faq\Service\FormService;
use HDNET\Faq\Service\SchemaService;
use Psr\Http\Message\ResponseInterface;
use HDNET\Autoloader\Annotation\Plugin;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

/**
 * FAQ.
 */
class FaqController extends AbstractController
{
    const TEASER_MODE_VOTING = 0;

    const TEASER_MODE_CUSTOM = 1;

    /**
     * Question repository.
     *
     * @var QuestionRepository
     */
    protected $questionRepository;

    /**
     * Question category repository.
     *
     * @var QuestionCategoryRepository
     */
    protected $questionCategoryRepository;

    /**
     * @var SchemaService
     */
    protected $schemaService;

    /**
     * @var bool
     */
    protected $addSchemaHeader = false;

    public function __construct(
        QuestionRepository $questionRepository,
        QuestionCategoryRepository $questionCategoryRepository,
        FormService $formValidationService,
        SchemaService $schemaService
    )
    {
        $this->questionRepository = $questionRepository;
        $this->questionCategoryRepository = $questionCategoryRepository;
        $this->formValidationService = $formValidationService;
        $this->schemaService = $schemaService;

        $this->addSchemaHeader = $this->settings['faq']['addSchmemaOrgHeader'] ?? true;
    }

    /**
     * @Plugin("Faq")
     */
    public function indexAction(): ResponseInterface
    {
        $questions = $this->questionRepository->findAll();

        if ($this->addSchemaHeader) {
            $this->schemaService->addSchemaOrgHeader($questions);
        }

        if ($this->request->getQueryParams()['tx_faq_faq']['currentPage']) {
            $currentPage = intval($this->request->getQueryParams()['tx_faq_faq']['currentPage']);
        } else {
            $currentPage = 1;
        }

        $paginator = new QueryResultPaginator($questions, $currentPage, (int)$this->settings['faq']['itemsPerPage']);
        $pagination = new SimplePagination($paginator);

        $this->view->assignMultiple([
            'questions' => $questions,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'pages' => range(1, $pagination->getLastPageNumber()),
            'categories' => $this->questionCategoryRepository->findByParent(0),
        ]);

        return $this->htmlResponse();
    }

    /**
     * @Plugin("Faq")
     */
    public function categoryAction(QuestionCategory $category): ResponseInterface
    {
        $categoryChildren = $this->questionCategoryRepository->findByParent($category->getUid());

        $this->view->assignMultiple([
            'category' => $category,
            'questions' => $this->questionRepository->findByCategories($categoryChildren)
        ]);
        return $this->htmlResponse();
    }

}
