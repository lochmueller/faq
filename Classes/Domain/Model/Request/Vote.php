<?php
/**
 * Vote.php
 *
 * @package    Hdnet
 * @author     Tim Spiekerkoetter
 */

namespace HDNET\Faq\Domain\Model\Request;

use HDNET\Faq\Exception\AlreadyVotedException;

/**
 * Vote
 *
 * @author     Tim Spiekerkoetter
 */
class Vote extends AbstractRequest
{

    const MODE_TOP = 1;

    const MODE_FLOP = 2;

    /**
     * @var \HDNET\Faq\Domain\Model\Question
     */
    protected $question;

    /**
     * One of the MODE_* variables
     *
     * @var int
     * @validate NumberRange(minimum=1, maximum=2)
     */
    protected $mode;

    /**
     *
     */
    public function updateQuestion()
    {
        $method = $this->buildModeMethod();
        call_user_func([
            $this->getQuestion(),
            'increase' . $method
        ]);
    }

    /**
     * @return string
     */
    protected function buildModeMethod()
    {
        switch ($this->getMode()) {
            case Vote::MODE_TOP:
                return 'TopCounter';
            case Vote::MODE_FLOP:
                return 'FlopCounter';
            default:
                throw new \BadMethodCallException;
        }
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return \HDNET\Faq\Domain\Model\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param \HDNET\Faq\Domain\Model\Question $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return int
     */
    public function getQuestionVotes()
    {
        $method = $this->buildModeMethod();
        return call_user_func([
            $this->getQuestion(),
            'get' . $method
        ]);
    }

    /**
     * @param array $votes
     *
     * @throws AlreadyVotedException
     */
    public function checkAgainst(array $votes)
    {
        if (in_array($this->getQuestion()
            ->getUid(), $votes)) {
            throw new AlreadyVotedException();
        }
    }
}
