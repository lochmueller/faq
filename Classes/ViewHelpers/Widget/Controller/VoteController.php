<?php

declare(strict_types = 1);
/**
 * VoteController.php.
 */

namespace HDNET\Faq\ViewHelpers\Widget\Controller;

use HDNET\Autoloader\Utility\TranslateUtility;
use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Domain\Model\Request\Vote;
use HDNET\Faq\Domain\Repository\QuestionRepository;
use HDNET\Faq\Exception\AlreadyVotedException;
use HDNET\Faq\Exception\VoteException;
use HDNET\Faq\Service\SessionService;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;

/**
 * VoteController.
 * @deprecated
 */
class VoteController extends AbstractWidgetController
{
    /**
     * Session service.
     *
     * @var SessionService
     */
    protected $sessionService;

    /**
     * Question repository.
     *
     * @var QuestionRepository
     */
    protected $questionRepository;

    public function __construct(SessionService $sessionService, QuestionRepository $questionRepository)
    {
        $this->sessionService = $sessionService;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Index action.
     */
    public function indexAction(): void
    {
        $this->view->assignMultiple([
            'top' => $this->widgetConfiguration['counters']['top'],
            'flop' => $this->widgetConfiguration['counters']['flop'],
            'question' => $this->widgetConfiguration['question'],
        ]);
    }

    /**
     * Vote action.
     *
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     *
     * @return string
     */
    public function voteAction(Question $question, int $mode)
    {
        $vote = $this->objectManager->get(Vote::class);
        $vote->setMode($mode);
        $vote->setQuestion($question);

        $result = [
            'state' => 'ERROR',
            'description' => 'Unknown',
            'currentCounter' => 0,
        ];

        $sessionIdentifier = 'topflop';

        try {
            $ids = $this->sessionService->setAndGet($sessionIdentifier, []);
            $vote->checkAgainst($ids);
            \array_push($ids, $vote->getQuestion()
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

        return \json_encode($result);
    }
}
