<?php

declare(strict_types = 1);
/**
 * Build up the Question category.
 */

namespace HDNET\Faq\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Build up the Question category.
 */
class QuestioncategoryRepository extends AbstractRepository
{
    /**
     * Default sorting.
     *
     * @var array
     */
    protected $defaultOrderings = ['sorting' => QueryInterface::ORDER_ASCENDING];

    /**
     * Create query.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
     */
    public function createQuery()
    {
        $query = parent::createQuery();
        $query->getQuerySettings()
            ->setRespectStoragePage(false);

        return $query;
    }

    /**
     * Find the categories in the right order (default: default, $sorting=TRUE: alphabetical).
     *
     * @param int  $topCategory
     * @param bool $sorting
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByParent($topCategory, $sorting = false)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('parent', $topCategory));
        if ($sorting) {
            $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        }

        return $query->execute();
    }
}
