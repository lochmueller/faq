<?php

declare(strict_types = 1);
/**
 * FAQ.
 */

namespace HDNET\Faq\Controller;

use HDNET\Autoloader\Annotation\Plugin;
use HDNET\Faq\Domain\Model\QuestionCategory;
use HDNET\Faq\Domain\Repository\QuestionCategoryRepository;
use HDNET\Faq\Domain\Repository\QuestionRepository;
use HDNET\Faq\Service\SchemaService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

/**
 * FAQ.
 */
class FaqController extends AbstractController
{
    protected QuestionRepository $questionRepository;

    protected QuestionCategoryRepository $questionCategoryRepository;

    protected SchemaService $schemaService;

    protected bool $addSchemaHeader = false;

    public function __construct(
        QuestionRepository $questionRepository,
        QuestionCategoryRepository $questionCategoryRepository,
        SchemaService $schemaService
    ) {
        $this->questionRepository = $questionRepository;
        $this->questionCategoryRepository = $questionCategoryRepository;
        $this->schemaService = $schemaService;

        $this->addSchemaHeader = (bool)($this->settings['faq']['addSchmemaOrgHeader'] ?? true);
    }

    /**
     * @Plugin("Faq")
     */
    public function indexAction(QuestionCategory $category = null): ResponseInterface
    {
        $categoryUid = $category ? (int)$category->getUid() : (int)($this->settings['initialCategory'] ?? 0);
        $categoryChildren = $this->questionCategoryRepository->findByParent($categoryUid);
        $questionsPerSubCategory = [];
        $allQuestions = [];
        $questions = null;
        if (!empty($categoryChildren->toArray())) {
            $allQuestions = $this->questionRepository->findByCategories($categoryChildren);
        }

        foreach ($categoryChildren as $subCategory) {
            $questions = $this->questionRepository->findByCategories([$subCategory]);
            if (0 !== $questions->count()) {
                $questionsPerSubCategory[] = [
                    'category' => $subCategory,
                    'questions' => $questions,
                ];
            }
        }

        if ($this->addSchemaHeader) {
            $this->schemaService->addSchemaOrgHeader($allQuestions);
        }

        if ($this->request->getQueryParams()['tx_faq_faq']['currentPage'] ?? null) {
            $currentPage = (int)($this->request->getQueryParams()['tx_faq_faq']['currentPage']);
        } else {
            $currentPage = 1;
        }

        $paginator = null;
        $pagination = null;
        if ($questions) {
            $paginator = new QueryResultPaginator($questions, $currentPage, (int)$this->settings['faq']['itemsPerPage']);
            $pagination = new SimplePagination($paginator);
        }

        $this->view->assignMultiple([
            'category' => $category,
            'questions' => $allQuestions,
            'subCategories' => $questionsPerSubCategory,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'pages' => $pagination ? range(1, $pagination->getLastPageNumber()) : [],
            'categories' => $this->questionCategoryRepository->findByParent(0),
        ]);

        return $this->htmlResponse();
    }

    /**
     * @Plugin("FaqAll")
     */
    public function allAction(): ResponseInterface
    {
        $parentCategories = $this->questionCategoryRepository->findAllParentCategories();
        $questionsPerCategory = [];

        /** @var QuestionCategory $parentCategory */
        foreach ($parentCategories as $parentCategory) {
            $questionsPerCategory[] = $this->getQuestionRec($parentCategory);
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
        $errors = [];
        $category = null;
        $questions = [];
        $categoryUid = $this->settings['initialCategory'];

        if ('' === $categoryUid) {
            $errors[] = 'plugin.FaqSingleCategory.errors.noCategorySelected';
        } else {
            $category = $this->questionCategoryRepository->findByUid($categoryUid);
            $questions = $this->questionRepository->findByCategory($category);
        }

        $this->view->assignMultiple([
            'category' => $category,
            'questions' => $questions,
            'errors' => $errors,
        ]);

        return $this->htmlResponse();
    }

    private function getQuestionRec(QuestionCategory $category)
    {
        $childCategories = $this->questionCategoryRepository->findByParent($category->getUid())->toArray();
        $element = [
            'category' => $category,
            'questions' => $this->questionRepository->findByCategory($category)->toArray(),
        ];
        if ($childCategories) {
            $childElements = [];
            foreach ($childCategories as $childCategory) {
                $childElements[] = $this->getQuestionRec($childCategory);
            }
            $element['childElements'] = $childElements;
        }

        return $element;
    }
}
