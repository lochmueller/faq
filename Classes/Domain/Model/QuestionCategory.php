<?php

declare(strict_types = 1);

namespace HDNET\Faq\Domain\Model;

class QuestionCategory extends AbstractModel
{
    /**
     * Title.
     *
     * @var string
     */
    protected $title;

    /**
     * Parent.
     *
     * @var QuestionCategory
     */
    protected $parent;

    /**
     * Description.
     *
     * @var string|null
     */
    protected $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
