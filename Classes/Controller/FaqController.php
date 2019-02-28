<?php
/**
 * FAQ
 *
 * @author     Tim Lochmüller
 */

namespace HDNET\Faq\Controller;

use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Domain\Model\Request\Faq;
use HDNET\Faq\Domain\Model\Request\QuestionRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * FAQ
 */
class FaqController extends AbstractController
{

    const TEASER_MODE_VOTING = 0;

    const TEASER_MODE_CUSTOM = 1;

    /**
     * Question repository
     *
     * @var \HDNET\Faq\Domain\Repository\QuestionRepository
     * @inject
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $questionRepository;

    /**
     * Question category repository
     *
     * @var \HDNET\Faq\Domain\Repository\QuestioncategoryRepository
     * @inject
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $questioncategoryRepository;

    /**
     * Index action
     *
     * @param \HDNET\Faq\Domain\Model\Request\Faq $faq
     * @param bool $showAll
     */
    public function indexAction(Faq $faq = null, $showAll = false)
    {
        $topCategory = (int)$this->settings['faq']['topCategory'];

        if ((bool)$this->settings['overrideShowAll'] === true) {
            $showAll = true;
        }
        if ((int)$this->settings['overrideTopCategory'] !== 0) {
            $topCategory = (int)$this->settings['overrideTopCategory'];
        }

        if (is_object($faq)) {
            $questions = $this->questionRepository->findByFaq($faq, $topCategory);
            $showResults = true;
        } elseif ($showAll) {
            $showResults = true;
            $questions = $this->questionRepository->findAll($topCategory);
        } else {
            $questions = [];
            $showResults = false;
        }

        if ($this->settings['topMode'] == self::TEASER_MODE_VOTING) {
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

        if ($faq === null) {
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
            'categories' => $this->questioncategoryRepository->findByParent(
                $topCategory,
                (bool)$this->settings['faq']['categorySort'] ?: false
            )
        ]);
    }

    /**
     * Render the teaser action
     */
    public function teaserAction()
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
     * Render the detail action
     *
     * @param \HDNET\Faq\Domain\Model\Question $question
     */
    public function detailAction(Question $question)
    {
        $this->view->assign('question', $question);
    }

    /**
     * Enter form
     *
     * @param \HDNET\Faq\Domain\Model\Request\QuestionRequest $question
     * @ignorevalidation $question
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $question
     */
    public function formAction(QuestionRequest $question = null)
    {
        if ($question === null) {
            $question = new QuestionRequest();
        }

        $this->view->assign('question', $question);
    }

    /**
     * Send action
     *
     * @param \HDNET\Faq\Domain\Model\Request\QuestionRequest $question
     * @param string $captcha
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function sendAction(QuestionRequest $question, $captcha = null)
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
     * user action
     *
     * @param \HDNET\Faq\Domain\Model\Request\QuestionRequest $question
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function userAction(QuestionRequest $question)
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
     * Get the target Email address
     *
     * @return string
     * @throws \Exception
     */
    protected function getTargetEmailAddress()
    {
        if (isset($this->settings['faq']['targetEmail']) && GeneralUtility::validEmail(trim($this->settings['faq']['targetEmail']))) {
            return trim($this->settings['faq']['targetEmail']);
        }
        throw new \Exception('No target e-mail address found', 123718231823);
    }

    /**
     * Send action
     *
     * @param \HDNET\Faq\Domain\Model\Request\QuestionRequest $question
     */
    public function thanksAction(QuestionRequest $question)
    {
        $this->disableIndexing();
        $this->view->assign('question', $question);
    }
}
