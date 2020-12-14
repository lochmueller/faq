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
     * @EnableRichText()
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
     * @var \DateTime
     */
    protected $crdate;

    /**
     * Question constructor.
     */
    public function __construct()
    {
        $this->categories = new ObjectStorage();
        $this->crdate = new \DateTime();
    }

    /**
     * Set the title.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set answer.
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * Get answer.
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * Set tags.
     */
    public function setTags(string $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * Get tags.
     */
    public function getTags(): string
    {
        return $this->tags;
    }

    /**
     * Set the top counter.
     */
    public function setTopCounter(int $topCounter): void
    {
        $this->topCounter = $topCounter;
    }

    /**
     * Get the top counter.
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
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Set the Flop Counter.
     */
    public function setFlopCounter(int $flopCounter): void
    {
        $this->flopCounter = $flopCounter;
    }

    /**
     * Get the flop counter.
     */
    public function getFlopCounter(): int
    {
        return (int)$this->flopCounter;
    }

    /**
     * Public getter for the languageUid.
     */
    public function getLanguageId(): int
    {
        return $this->_languageUid;
    }
    
    public function getCrdate(): \DateTime
    {
        return $this->crdate;
    }
}
