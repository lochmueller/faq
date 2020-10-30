<?php

declare(strict_types = 1);
/**
 * Questioncategory / Fragen Kategorie.
 */

namespace HDNET\Faq\Domain\Model;

use HDNET\Autoloader\Annotation\DatabaseField;
use HDNET\Autoloader\Annotation\DatabaseTable;

/**
 * Questioncategory / Fragen Kategorie.
 *
 * @DatabaseTable
 */
class QuestionCategory extends AbstractModel
{
    /**
     * Title.
     *
     * @var string
     * @DatabaseField(type="string")
     */
    protected $title;

    /**
     * Parent.
     *
     * @var QuestionCategory
     * @DatabaseField(type="int", sql="int(11) DEFAULT '0' NOT NULL")
     */
    protected $parent;

    /**
     * @var int
     */
    protected $_languageUid = 0;

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
     * Set the parent.
     */
    public function setParent(self $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * Get the parent.
     */
    public function getParent(): self
    {
        return $this->parent;
    }

    /**
     * Public getter for the languageUid.
     */
    public function getLanguageUid(): int
    {
        return $this->_languageUid;
    }
}
