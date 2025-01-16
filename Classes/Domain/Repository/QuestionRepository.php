<?php

declare(strict_types = 1);
/**
 * Build up the Question.
 */

namespace HDNET\Faq\Domain\Repository;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ClassNamingUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

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

        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('faq');

        if ($extensionConfiguration['enableManuallySorting'] ?? false) {
            $this->defaultOrderings = [
                'sorting' => QueryInterface::ORDER_ASCENDING,
            ];
        }
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

        return $query->execute();
    }

    public function findByCategory($category)
    {
        return $this->findByCategories([$category]);
    }
}
