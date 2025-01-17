<?php

declare(strict_types = 1);
/**
 * Question / Frage.
 */

namespace HDNET\Faq\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Question / Frage.
 *
 * 
 */
class Question extends AbstractModel
{
    /**
     * Title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * Answer.
     *
     * @var string
     */
    protected $answer = '';

    /**
     * Tags.
     *
     * @var string
     */
    protected $tags = '';

    /**
     * Categories.
     *
     * @var ObjectStorage<QuestionCategory>
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

    public function getCrdate(): \DateTime
    {
        return $this->crdate;
    }
}
