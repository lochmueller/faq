<?php
/**
 * Request Faq
 *
 * @author     Tim Lochmüller
 */

namespace HDNET\Faq\Domain\Model\Request;

/**
 * Request Faq
 */
class QuestionRequest extends AbstractRequest
{

    /**
     * Question
     *
     * @var string
     * @validate NotEmpty
     */
    protected $question;

    /**
     * E-Mail
     *
     * @var string
     * @validate NotEmpty
     * @validate EmailAddress
     */
    protected $email;

    /**
     * Set E-mail
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get E-Mail
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set question
     *
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

}
