<?php

declare(strict_types = 1);
/**
 * Vote.php.
 */

namespace HDNET\Faq\Domain\Model\Request;

use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Exception\AlreadyVotedException;
use TYPO3\CMS\Extbase\Annotation\Validate;

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
     * @var Question
     */
    protected $question;

    /**
     * One of the MODE_* variables.
     *
     * @var int
     * @Validate(validator="NumberRange", options={"minimum=1", "maximum=2"})
     */
    protected $mode;

    /**
     * Update question.
     */
    public function updateQuestion(): void
    {
        $method = $this->buildModeMethod();
        \call_user_func([
            $this->getQuestion(),
            'increase' . $method,
        ]);
    }

    /**
     * Get mode.
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * Set mode.
     */
    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * Get question.
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * Set question.
     */
    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    /**
     * Get question votes.
     */
    public function getQuestionVotes(): int
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
     * @throws AlreadyVotedException
     */
    public function checkAgainst(array $votes): void
    {
        if (\in_array($this->getQuestion()
            ->getUid(), $votes, true)) {
            throw new AlreadyVotedException();
        }
    }

    /**
     * Build mode method.
     */
    protected function buildModeMethod(): string
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
