<?php
/**
 * Question / Frage
 *
 * @author     Tim Lochmüller
 */

namespace HDNET\Faq\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Question / Frage
 *
 * @db
 */
class Question extends AbstractModel
{

    /**
     * Title
     *
     * @var string
     * @db
     */
    protected $title;

    /**
     * Answer
     *
     * @var string
     * @db
     */
    protected $answer;

    /**
     * Tags
     *
     * @var string
     * @db
     */
    protected $tags;

    /**
     * Top Counter
     *
     * @var int
     * @db
     */
    protected $topCounter;

    /**
     * Flop Counter
     *
     * @var int
     * @db
     */
    protected $flopCounter;

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Faq\Domain\Model\Questioncategory>
     * @db int(11) DEFAULT '0' NOT NULL
     */
    protected $categories;

    public function __construct()
    {
        $this->categories = new ObjectStorage();
    }

    /**
     * Set the title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set answer
     *
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set tags
     *
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the top counter
     *
     * @param int $topCounter
     */
    public function setTopCounter($topCounter)
    {
        $this->topCounter = $topCounter;
    }

    /**
     * Get the top counter
     *
     * @return int
     */
    public function getTopCounter()
    {
        return (int)$this->topCounter;
    }

    /**
     * Set the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the Flop Counter
     *
     * @param int $flopCounter
     */
    public function setFlopCounter($flopCounter)
    {
        $this->flopCounter = $flopCounter;
    }

    /**
     * Get the flop counter
     *
     * @return int
     */
    public function getFlopCounter()
    {
        return (int)$this->flopCounter;
    }
}
