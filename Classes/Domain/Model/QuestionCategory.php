<?php

declare(strict_types = 1);
/**
 * Questioncategory / Fragen Kategorie.
 */

namespace HDNET\Faq\Domain\Model;

use HDNET\Autoloader\Annotation\DatabaseField;
use HDNET\Autoloader\Annotation\DatabaseTable;
use HDNET\Autoloader\Annotation\EnableRichText;

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
     * Description.
     *
     * @var string
     * @DatabaseField(type="string")
     * @EnableRichText
     */
    protected $description;

    /**
     * @var int
     */
    protected $_languageUid = 0;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setParent(self $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function getLanguageUid(): int
    {
        return $this->_languageUid;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
