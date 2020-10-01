<?php

declare(strict_types = 1);
/**
 * Question / Frage.
 */

namespace HDNET\Faq\Domain\Model;

use HDNET\Autoloader\Annotation\DatabaseField;
use HDNET\Autoloader\Annotation\DatabaseTable;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Question / Frage.
 *
 * @DatabaseTable
 *
 */
class Question extends AbstractModel
{
    /**
     * Title.
     *
     * @var string
     * @DatabaseField(type="string")
     */
    protected $title = '';

    /**
     * Answer.
     *
     * @var string
     * @DatabaseField(type="string")
     */
    protected $answer = '';

    /**
     * Tags.
     *
     * @var string
     * @DatabaseField(type="string")
     */
    protected $tags = '';

    /**
     * Top Counter.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $topCounter = 0;

    /**
     * Flop Counter.
     *
     * @var int
     * @DatabaseField(type="int")
     */
    protected $flopCounter = 0;

    /**
     * @var int
     */
    protected $_languageUid = 0;

    /**
     * Categories.
     *
     * @var ObjectStorage<QuestionCategory>
     * @DatabaseField(type="int", sql="int(11) DEFAULT '0' NOT NULL")
     */
    protected $categories;

    /**
     * Question constructor.
     */
    public function __construct()
    {
        $this->categories = new ObjectStorage();
    }

    /**
     * Set the title.
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set answer.
     *
     * @param string $answer
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * Get answer.
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * Set tags.
     *
     * @param string $tags
     */
    public function setTags(string $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * Get tags.
     *
     * @return string
     */
    public function getTags(): string
    {
        return $this->tags;
    }

    /**
     * Set the top counter.
     *
     * @param int $topCounter
     */
    public function setTopCounter(int $topCounter): void
    {
        $this->topCounter = $topCounter;
    }

    /**
     * Get the top counter.
     *
     * @return int
     */
    public function getTopCounter(): int
    {
        return (int)$this->topCounter;
    }

    /**
     * Set the categories.
     *
     * @param ObjectStorage $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Get the categories.
     *
     * @return ObjectStorage
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Set the Flop Counter.
     *
     * @param int $flopCounter
     */
    public function setFlopCounter(int $flopCounter): void
    {
        $this->flopCounter = $flopCounter;
    }

    /**
     * Get the flop counter.
     *
     * @return int
     */
    public function getFlopCounter(): int
    {
        return (int)$this->flopCounter;
    }

    /**
     * Public getter for the languageUid.
     *
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->_languageUid;
    }
}
