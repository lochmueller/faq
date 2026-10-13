<?php

declare(strict_types = 1);

namespace HDNET\Faq\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class QuestionCategoryRepository extends Repository
{
    /**
     * Default sorting.
     *
     * @var array
     */
    protected $defaultOrderings = ['sorting' => QueryInterface::ORDER_ASCENDING];

    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        // Show categories from all pages
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Find the categories in the right order (default: default, $sorting=TRUE: alphabetical).
     *
     * @return array|QueryResultInterface
     */
    public function findByParent(int $topCategory, bool $sorting = false)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('parent', $topCategory));
        if ($sorting) {
            $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        }

        return $query->execute();
    }

    /**
     * Find all categories without a parent (top level categories).
     *
     * @return array|QueryResultInterface
     */
    public function findAllParentCategories()
    {
        return $this->findByParent(0);
    }
}
