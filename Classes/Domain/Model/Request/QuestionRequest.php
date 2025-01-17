<?php

declare(strict_types = 1);

namespace HDNET\Faq\Domain\Model\Request;

use TYPO3\CMS\Extbase\Annotation\Validate;

class QuestionRequest extends AbstractRequest
{
    /**
     * Question.
     *
     * @var string
     *
     * @Validate(validator="NotEmpty")
     */
    protected $question;

    /**
     * E-Mail.
     *
     * @var string
     *
     * @Validate(validator="NotEmpty")
     * @Validate(validator="EmailAddress")
     */
    protected $email;

    /**
     * Set E-mail.
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get E-Mail.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set question.
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * Get question.
     */
    public function getQuestion(): string
    {
        return $this->question;
    }
}
