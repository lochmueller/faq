<?php

declare(strict_types = 1);

namespace HDNET\Faq\Domain\Repository;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class QuestionRepository extends Repository
{
    /**
     * Orderings.
     *
     * @var array
     */
    protected $defaultOrderings = [
        'title' => QueryInterface::ORDER_ASCENDING,
    ];

    public function __construct(ExtensionConfiguration $extensionConfiguration)
    {
        parent::__construct();

        if ($extensionConfiguration->get('faq')['enableManuallySorting'] ?? false) {
            $this->defaultOrderings = [
                'sorting' => QueryInterface::ORDER_ASCENDING,
            ];
        }
    }

    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        // Show questions from all pages
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function findByCategories($categories)
    {
        $query = $this->createQuery();

        $categorySelection = [];

        if (!is_iterable($categories)) {
            $categories = GeneralUtility::intExplode(',', $categories);
        }

        foreach ($categories as $category) {
            $categorySelection[] = $query->contains('categories', $category);
        }

        if ([] === $categorySelection) {
            // No categories given: match nothing instead of everything
            $query->matching($query->equals('uid', 0));

            return $query->execute();
        }

        $query->matching($query->logicalOr(...$categorySelection));

        return $query->execute();
    }

    public function findByCategory($category)
    {
        return $this->findByCategories([$category]);
    }
}
