<?php

declare(strict_types = 1);
/**
 * Request Faq.
 */

namespace HDNET\Faq\Domain\Model\Request;

use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Request Faq.
 */
class QuestionRequest extends AbstractRequest
{
    /**
     * Question.
     *
     * @var string
     * @Validate(validator="NotEmpty")
     */
    protected $question;

    /**
     * E-Mail.
     *
     * @var string
     * @Validate(validator="NotEmpty")
     * @Validate(validator="EmailAddress")
     */
    protected $email;

    /**
     * Set E-mail.
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get E-Mail.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set question.
     *
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * Get question.
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }
}
