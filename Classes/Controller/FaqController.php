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
    public function indexAction(QuestionCategory $category = null): ResponseInterface
    {
        // TODO: Check if a category without subCategories is given
        $categoryUid = $category ? (int) $category->getUid() : (int) $this->settings['initialCategory'];
        $categoryChildren = $this->questionCategoryRepository->findByParent($categoryUid);
        $questionsPerSubCategory = [];
        $allQuestions = $this->questionRepository->findByCategories($categoryChildren);

        foreach ($categoryChildren as $subCategory) {
            $questions = $this->questionRepository->findByCategories([$subCategory]);
            if ($questions->count() !== 0) {
                $questionsPerSubCategory[] = [
                    'category' => $subCategory,
                    'questions' => $questions,
                ];
            }
        }

        if ($this->addSchemaHeader) {
            $this->schemaService->addSchemaOrgHeader($allQuestions);
        }

        if ($this->request->getQueryParams()['tx_faq_faq']['currentPage']) {
            $currentPage = intval($this->request->getQueryParams()['tx_faq_faq']['currentPage']);
        } else {
            $currentPage = 1;
        }

        $paginator = new QueryResultPaginator($questions, $currentPage, (int)$this->settings['faq']['itemsPerPage']);
        $pagination = new SimplePagination($paginator);

        $this->view->assignMultiple([
            'questions' => $allQuestions,
            'subCategories' => $questionsPerSubCategory,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'pages' => range(1, $pagination->getLastPageNumber()),
            'categories' => $this->questionCategoryRepository->findByParent(0),
        ]);

        return $this->htmlResponse();
    }

    /**
     * @Plugin("FaqAll")
     */
    public function allAction(): ResponseInterface
    {
        // Todo: Check if only one oder more than 2 level(s) of categories is/are available
        $parentCategories = $this->questionCategoryRepository->findAllParentCategories();
        $questionsPerCategory = [];

        /** @var QuestionCategory $parentCategory */
        foreach ($parentCategories as $parentCategory) {
            $questionsPerSubCategory = [];
            $categoryChildren = $this->questionCategoryRepository->findByParent($parentCategory->getUid());

            foreach ($categoryChildren as $subCategory) {
                $questions = $this->questionRepository->findByCategories([$subCategory]);
                if ($questions->count() !== 0) {
                    $questionsPerSubCategory[] = [
                        'category' => $subCategory,
                        'questions' => $questions,
                    ];
                }
            }

            $questionsPerCategory[] = [
                'category' => $parentCategory,
                'subCategories' => $questionsPerSubCategory
            ];
        }

        if ($this->addSchemaHeader) {
            $allQuestions = $this->questionRepository->findAll();
            $this->schemaService->addSchemaOrgHeader($allQuestions);
        }

        $this->view->assignMultiple([
            'questionsPerCategory' => $questionsPerCategory,
            'categories' => $this->questionCategoryRepository->findByParent(0),
        ]);

        return $this->htmlResponse();
    }

    /**
     * @Plugin("FaqSingleCategory")
     */
    public function singleCategoryAction(): ResponseInterface
    {
        // TODO: Check if parent category is selected. Is this valid? Or only direct parent of questions
        // are available to select?
        $categoryUid = $this->settings['initialCategory'];
        $category = $this->questionCategoryRepository->findByUid($categoryUid);

        $questions = $this->questionRepository->findByCategory($category);

        $this->view->assignMultiple([
            'category' => $category,
            'questions' => $questions,
        ]);


        return $this->htmlResponse();
    }
}
