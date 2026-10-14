<?php

declare(strict_types = 1);

namespace HDNET\Faq\Controller;

use HDNET\Faq\Domain\Model\QuestionCategory;
use HDNET\Faq\Domain\Repository\QuestionCategoryRepository;
use HDNET\Faq\Domain\Repository\QuestionRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

class FaqController extends ActionController
{
    public function __construct(
        protected readonly QuestionRepository $questionRepository,
        protected readonly QuestionCategoryRepository $questionCategoryRepository,
    ) {
    }

    public function indexAction(?QuestionCategory $category = null): ResponseInterface
    {
        $categoryUid = $category instanceof QuestionCategory
            ? (int)$category->getUid()
            : (int)($this->settings['initialCategory'] ?? 0);

        $questions = $this->questionRepository->findByCategories(
            $this->questionCategoryRepository->findByParent($categoryUid)
        );

        $itemsPerPage = max(1, (int)($this->settings['faq']['itemsPerPage'] ?? 10));
        $paginator = new QueryResultPaginator($questions, $this->getCurrentPage(), $itemsPerPage);
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

    public function allAction(): ResponseInterface
    {
        $questionsPerCategory = [];

        foreach ($this->questionCategoryRepository->findAllParentCategories() as $parentCategory) {
            $questionsPerCategory[] = $this->getQuestionRec($parentCategory);
        }

        $this->view->assignMultiple([
            'questionsPerCategory' => $questionsPerCategory,
            'categories' => $this->questionCategoryRepository->findByParent(0),
        ]);

        return $this->htmlResponse();
    }

    public function singleCategoryAction(): ResponseInterface
    {
        $errors = [];
        $category = null;
        $questions = [];
        $categoryUid = $this->settings['initialCategory'] ?? null;

        if (empty($categoryUid) || !is_numeric($categoryUid)) {
            $errors[] = 'plugin.FaqSingleCategory.errors.noCategorySelected';
        } else {
            $category = $this->questionCategoryRepository->findByUid((int)$categoryUid);
            if ($category instanceof QuestionCategory) {
                $questions = $this->questionRepository->findByCategory($category);
            }
        }

        $this->view->assignMultiple([
            'category' => $category,
            'questions' => $questions,
            'errors' => $errors,
        ]);

        return $this->htmlResponse();
    }

    private function getQuestionRec(QuestionCategory $category): array
    {
        $childCategories = $this->questionCategoryRepository->findByParent((int)$category->getUid())->toArray();
        $element = [
            'category' => $category,
            'questions' => $this->questionRepository->findByCategory($category)->toArray(),
        ];
        if ([] !== $childCategories) {
            $childElements = [];
            foreach ($childCategories as $childCategory) {
                $childElements[] = $this->getQuestionRec($childCategory);
            }
            $element['childElements'] = $childElements;
        }

        return $element;
    }

    private function getCurrentPage(): int
    {
        $currentPage = $this->request->hasArgument('currentPage')
            ? (int)$this->request->getArgument('currentPage')
            : 1;

        return max(1, $currentPage);
    }
}
