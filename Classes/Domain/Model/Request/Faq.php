<?php

declare(strict_types = 1);

namespace HDNET\Faq\Domain\Model\Request;

use HDNET\Faq\Domain\Model\QuestionCategory;

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
     */
    public function setCategory(QuestionCategory $category): void
    {
        $this->category = $category;
    }

    /**
     * Get the category.
     */
    public function getCategory(): ?QuestionCategory
    {
        return $this->category;
    }

    /**
     * Set and trim the search word.
     */
    public function setSearchWord(string $searchWord): void
    {
        $this->searchWord = mb_trim($searchWord);
    }

    /**
     * get the trim search word.
     */
    public function getSearchWord(): string
    {
        return mb_trim((string)$this->searchWord);
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }
}
