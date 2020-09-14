<?php

declare(strict_types = 1);
/**
 * Request Faq.
 */

namespace HDNET\Faq\Domain\Model\Request;

use HDNET\Faq\Domain\Model\QuestionCategory;

/**
 * Request Faq.
 */
class Faq extends AbstractRequest
{
    /**
     * Category.
     *
     * @var QuestionCategory
     */
    protected $category;

    /**
     * Categories (for checkbox selection).
     *
     * @var array
     */
    protected $categories = [];

    /**
     * Search word.
     *
     * @var string
     */
    protected $searchWord = '';

    /**
     * Set the category.
     *
     * @param QuestionCategory $category
     */
    public function setCategory(QuestionCategory $category): void
    {
        $this->category = $category;
    }

    /**
     * Get the category.
     *
     * @return QuestionCategory
     */
    public function getCategory(): QuestionCategory
    {
        return $this->category;
    }

    /**
     * Set and trim the search word.
     *
     * @param string $searchWord
     */
    public function setSearchWord(string $searchWord): void
    {
        $this->searchWord = \trim((string)$searchWord);
    }

    /**
     * get the trim search word.
     *
     * @return string
     */
    public function getSearchWord(): string
    {
        return \trim((string)$this->searchWord);
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }
}
