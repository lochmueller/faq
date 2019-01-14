<?php
/**
 * VoteController.php
 *
 * @package    Hdnet
 * @author     Tim Spiekerkoetter
 */

namespace HDNET\Faq\ViewHelpers\Widget\Controller;

use HDNET\Autoloader\Utility\TranslateUtility;
use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Domain\Model\Request\Vote;
use HDNET\Faq\Exception\AlreadyVotedException;
use HDNET\Faq\Exception\VoteException;

/**
 * VoteController
 *
 * @author     Tim Spiekerkoetter
 */
class VoteController extends AbstractWidgetController
{

    /**
     * Session service
     *
     * @var \HDNET\Faq\Service\SessionService
     * @inject
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $sessionService;

    /**
     * Question repository
     *
     * @var \HDNET\Faq\Domain\Repository\QuestionRepository
     * @inject
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $questionRepository;

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->assignMultiple([
            'top' => $this->widgetConfiguration['counters']['top'],
            'flop' => $this->widgetConfiguration['counters']['flop'],
            'question' => $this->widgetConfiguration['question']
        ]);
    }

    /**
     * Vote action
     *
     * @param Question $question
     * @param int $mode
     *
     * @return string
     */
    public function voteAction(Question $question, $mode)
    {
        $vote = $this->objectManager->get(Vote::class);
        $vote->setMode($mode);
        $vote->setQuestion($question);

        $result = [
            'state' => 'ERROR',
            'description' => 'Unknown',
            'currentCounter' => 0
        ];

        $sessionIdentifier = 'topflop';

        try {
            $ids = $this->sessionService->setAndGet($sessionIdentifier, []);
            $vote->checkAgainst($ids);
            array_push($ids, $vote->getQuestion()
                ->getUid());
            $this->sessionService->set($sessionIdentifier, $ids);
            $vote->updateQuestion();
            $this->questionRepository->update($vote->getQuestion());
            $result['state'] = 'OK';
            $result['description'] = TranslateUtility::assureLabel(
                'eid.ok',
                'faq',
                'Vielen Dank f&uuml;r Ihre Wertung.'
            );
            $result['currentCounter'] = $vote->getQuestionVotes();
        } catch (AlreadyVotedException $e) {
            $result['description'] = TranslateUtility::assureLabel(
                'eid.error.multivote',
                'faq',
                'Sie haben f&uuml;r diese Frage bereits abgestimmt!'
            );
        } catch (VoteException $e) {
            $result['description'] = $e->getMessage();
        }

        return json_encode($result);
    }
}
