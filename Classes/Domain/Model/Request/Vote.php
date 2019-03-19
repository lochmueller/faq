<?php

declare(strict_types = 1);
/**
 * Vote.php.
 */

namespace HDNET\Faq\Domain\Model\Request;

use HDNET\Faq\Exception\AlreadyVotedException;

/**
 * Vote.
 */
class Vote extends AbstractRequest
{
    const MODE_TOP = 1;

    const MODE_FLOP = 2;

    /**
     * Question.
     *
     * @var \HDNET\Faq\Domain\Model\Question
     */
    protected $question;

    /**
     * One of the MODE_* variables.
     *
     * @var int
     * @validate NumberRange(minimum=1, maximum=2)
     */
    protected $mode;

    /**
     * Update question.
     */
    public function updateQuestion()
    {
        $method = $this->buildModeMethod();
        \call_user_func([
            $this->getQuestion(),
            'increase' . $method,
        ]);
    }

    /**
     * Get mode.
     *
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set mode.
     *
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Get question.
     *
     * @return \HDNET\Faq\Domain\Model\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set question.
     *
     * @param \HDNET\Faq\Domain\Model\Question $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Get question votes.
     *
     * @return int
     */
    public function getQuestionVotes()
    {
        $method = $this->buildModeMethod();

        return \call_user_func([
            $this->getQuestion(),
            'get' . $method,
        ]);
    }

    /**
     * Check against.
     *
     * @param array $votes
     *
     * @throws AlreadyVotedException
     */
    public function checkAgainst(array $votes)
    {
        if (\in_array($this->getQuestion()
            ->getUid(), $votes, true)) {
            throw new AlreadyVotedException();
        }
    }

    /**
     * Build mode method.
     *
     * @return string
     */
    protected function buildModeMethod()
    {
        switch ($this->getMode()) {
            case self::MODE_TOP:
                return 'TopCounter';
            case self::MODE_FLOP:
                return 'FlopCounter';
            default:
                throw new \BadMethodCallException();
        }
    }
}
