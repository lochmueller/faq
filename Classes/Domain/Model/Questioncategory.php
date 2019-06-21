<?php

declare(strict_types = 1);
/**
 * Questioncategory / Fragen Kategorie.
 */

namespace HDNET\Faq\Domain\Model;

/**
 * Questioncategory / Fragen Kategorie.
 *
 * @db
 */
class Questioncategory extends AbstractModel
{
    /**
     * Title.
     *
     * @var string
     * @db
     */
    protected $title;

    /**
     * Parent.
     *
     * @var \HDNET\Faq\Domain\Model\Questioncategory
     * @db  int(11) DEFAULT '0' NOT NULL
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
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the parent.
     *
     * @param \HDNET\Faq\Domain\Model\Questioncategory $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get the parent.
     *
     * @return \HDNET\Faq\Domain\Model\Questioncategory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Public getter for the languageUid
     * @return int
     */
    public function getLanguageUid()
    {
        return $this->_languageUid;
    }
}
