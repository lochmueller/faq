<?php

declare(strict_types = 1);
/**
 * Build up the Question.
 */

namespace HDNET\Faq\Domain\Repository;

use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Domain\Model\QuestionCategory;
use HDNET\Faq\Domain\Model\Request\Faq;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\ClassNamingUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Build up the Question.
 */
class QuestionRepository extends AbstractRepository
{
    /**
     * Orderings.
     *
     * @var array
     */
    protected $defaultOrderings = [
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * Constructs a new Repository.
     */
    public function __construct()
    {
        // Replace with parent constructor call in TYPO3 v12
        $this->objectType = ClassNamingUtility::translateRepositoryNameToModelName($this->getRepositoryClassName());
    }

    public function findByCategories($categories)
    {
        $query = $this->createQuery();

        $constraints = [];
        $categorySelection = [];

        if (!is_iterable($categories)) {
            $categories = GeneralUtility::intExplode(',', $categories);
        }

        foreach ($categories as $category) {
            $categorySelection[] = $query->contains('categories', $category);
        }

        $constraints[] = $query->logicalOr($categorySelection);

        $query->matching(
            $query->logicalAnd($constraints)
        );

        $result = $query->execute();

        return $result;
    }
}
