<?php
/**
 * Request Faq
 *
 * @author     Tim Lochmüller
 */

namespace HDNET\HdnetFaq\Domain\Model\Request;

/**
 * Request Faq
 * @db
 */
class Faq extends AbstractRequest {

	/**
	 * Category
	 *
	 * @var \HDNET\HdnetFaq\Domain\Model\Questioncategory
	 */
	protected $category;

	/**
	 * Search word
	 *
	 * @var string
	 */
	protected $searchWord;

	/**
	 * Set the category
	 *
	 * @param \HDNET\HdnetFaq\Domain\Model\Questioncategory $category
	 */
	public function setCategory($category) {
		$this->category = $category;
	}

	/**
	 * Get the category
	 *
	 * @return \HDNET\HdnetFaq\Domain\Model\Questioncategory
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Set and trim the search word
	 *
	 * @param string $searchWord
	 */
	public function setSearchWord($searchWord) {
		$this->searchWord = trim($searchWord);
	}

	/**
	 * get the trim search word
	 *
	 * @return string
	 */
	public function getSearchWord() {
		return trim($this->searchWord);
	}

}
