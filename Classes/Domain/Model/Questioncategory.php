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
     * Set the parent.
     *
     * @param QuestionCategory $parent
     */
    public function setParent(QuestionCategory $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * Get the parent.
     *
     * @return QuestionCategory
     */
    public function getParent(): QuestionCategory
    {
        return $this->parent;
    }

    /**
     * Public getter for the languageUid.
     *
     * @return int
     */
    public function getLanguageUid(): int
    {
        return $this->_languageUid;
    }
}
