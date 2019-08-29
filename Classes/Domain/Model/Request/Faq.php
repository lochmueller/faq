<?php

declare(strict_types = 1);
/**
 * Request Faq.
 */

namespace HDNET\Faq\Domain\Model\Request;

/**
 * Request Faq.
 */
class Faq extends AbstractRequest
{
    /**
     * Category.
     *
     * @var \HDNET\Faq\Domain\Model\Questioncategory
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
     * @param \HDNET\Faq\Domain\Model\Questioncategory $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get the category.
     *
     * @return \HDNET\Faq\Domain\Model\Questioncategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set and trim the search word.
     *
     * @param string $searchWord
     */
    public function setSearchWord($searchWord)
    {
        $this->searchWord = \trim((string)$searchWord);
    }

    /**
     * get the trim search word.
     *
     * @return string
     */
    public function getSearchWord()
    {
        return \trim((string)$this->searchWord);
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }
}
