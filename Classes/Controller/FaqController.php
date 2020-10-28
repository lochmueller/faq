<?php

declare(strict_types = 1);
/**
 * FAQ.
 */

namespace HDNET\Faq\Controller;

use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Domain\Model\Request\Faq;
use HDNET\Faq\Domain\Model\Request\QuestionRequest;
use HDNET\Faq\Domain\Repository\QuestionCategoryRepository;
use HDNET\Faq\Domain\Repository\QuestionRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;

/**
 * FAQ.
 */
class FaqController extends AbstractController
{
    const TEASER_MODE_VOTING = 0;

    const TEASER_MODE_CUSTOM = 1;

    /**
     * Question repository.
     *
     * @var QuestionRepository
     */
    protected $questionRepository;

    /**
     * Question category repository.
     *
     * @var QuestionCategoryRepository
     */
    protected $questionCategoryRepository;

    public function __construct(QuestionRepository $questionRepository, QuestionCategoryRepository $questionCategoryRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->questionCategoryRepository = $questionCategoryRepository;
    }

    /**
     * Index action.
     *
     * @throws InvalidQueryException
     */
    public function indexAction(Faq $faq = null, bool $showAll = false): void
    {
        $topCategory = (int)$this->settings['faq']['topCategory'];

        if (true === (bool)$this->settings['overrideShowAll']) {
            $showAll = true;
        }
        if (0 !== (int)$this->settings['overrideTopCategory']) {
            $topCategory = (int)$this->settings['overrideTopCategory'];
        }

        if (\is_object($faq)) {
            $questions = $this->questionRepository->findByFaq($faq, $topCategory);
            $showResults = true;
        } elseif ($showAll) {
            $showResults = true;
            $questions = $this->questionRepository->findAll($topCategory);
        } else {
            $questions = [];
            $showResults = false;
        }

        if (self::TEASER_MODE_VOTING === (int)$this->settings['topMode']) {
            $topQuestions = $this->questionRepository->findTop(
                (int)$this->settings['faq']['limitTop'],
                $topCategory,
                GeneralUtility::intExplode(',', $this->settings['faq']['topQuestions'], true)
            );
        } else {
            $topQuestions = $this->questionRepository->findByUidsSorted(GeneralUtility::intExplode(
                ',',
                $this->settings['custom'],
                true
            ));
        }

        if (null === $faq) {
            $faq = $this->objectManager->get(Faq::class);
        }

        $this->view->assignMultiple([
            'showResults' => $showResults,
            'faq' => $faq,
            'questions' => $questions,
            'newQuestions' => $this->questionRepository->findNewest(
                (int)$this->settings['faq']['limitNewest'],
                $topCategory
            ),
            'topQuestions' => $topQuestions,
            'categories' => $this->questionCategoryRepository->findByParent(
                $topCategory,
                (bool)$this->settings['faq']['categorySort'] ?: false
            ),
        ]);
    }

    /**
     * Render the teaser action.
     */
    public function teaserAction(): void
    {
        $topQuestions = GeneralUtility::intExplode(',', $this->settings['faq']['topQuestions'], true);
        $teaserCategories = GeneralUtility::intExplode(',', $this->settings['faq']['teaserCategories'], true);
        $teaserLimit = (int)$this->settings['faq']['teaserLimit'];
        $questions = $this->questionRepository->findByTeaserConfiguration(
            $topQuestions,
            $teaserCategories,
            $teaserLimit
        );
        $this->view->assign('questions', $questions);
    }

    /**
     * Render the detail action.
     */
    public function detailAction(Question $question): void
    {
        $this->view->assign('question', $question);
    }

    /**
     * Enter form.
     *
     * @IgnoreValidation(argumentName="question")
     */
    public function formAction(QuestionRequest $question = null): void
    {
        if (null === $question) {
            $question = new QuestionRequest();
        }

        $this->view->assign('question', $question);
    }

    /**
     * Send action.
     *
     * @throws StopActionException
     */
    public function sendAction(QuestionRequest $question, string $captcha = null): void
    {
        // @todo integrate captcha based on $this->settings['enableCaptcha']
        // * @validate $captcha \SJBR\SrFreecap\Validation\Validator\CaptchaValidator && Not Empty
        $this->disableIndexing();

        $targetEmailAddress = $this->getTargetEmailAddress();
        if (GeneralUtility::validEmail($targetEmailAddress)) {
            $this->view->assign('to', [$targetEmailAddress => $targetEmailAddress]);
            $this->view->assign('subject', 'Neue Frage eingestellt');
            $this->view->assign('question', $question);
            $this->view->assign('captcha', $captcha);
            $this->view->render();
        }
        $this->forward('user');
    }

    /**
     * user action.
     *
     * @throws StopActionException
     */
    public function userAction(QuestionRequest $question): void
    {
        if (GeneralUtility::validEmail($question->getEmail())) {
            $this->view->assignMultiple([
                'subject' => 'FAQ eingereicht',
                'to' => [$question->getEmail() => $question->getEmail()],
                'question' => $question,
            ]);
            $this->view->render();
        }
        $this->forward('thanks');
    }

    /**
     * Send action.
     */
    public function thanksAction(QuestionRequest $question): void
    {
        $this->disableIndexing();
        $this->view->assign('question', $question);
    }

    /**
     * Get the target Email address.
     *
     * @throws \Exception
     */
    protected function getTargetEmailAddress(): string
    {
        if (isset($this->settings['faq']['targetEmail']) && GeneralUtility::validEmail(\trim((string)$this->settings['faq']['targetEmail']))) {
            return \trim((string)$this->settings['faq']['targetEmail']);
        }
        throw new \Exception('No target e-mail address found', 123718231823);
    }
}
