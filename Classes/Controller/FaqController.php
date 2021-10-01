<?php

declare(strict_types=1);
/**
 * FAQ.
 */

namespace HDNET\Faq\Controller;

use HDNET\Faq\Domain\Factory\QuestionFormFactory;
use HDNET\Faq\Domain\Model\Question;
use HDNET\Faq\Domain\Model\Request\Faq;
use HDNET\Faq\Domain\Model\Request\QuestionRequest;
use HDNET\Faq\Domain\Repository\QuestionCategoryRepository;
use HDNET\Faq\Domain\Repository\QuestionRepository;
use HDNET\Faq\Service\FormService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;

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

    /**
     * @var FormService
     */
    protected $formValidationService;

    public function __construct(
        QuestionRepository $questionRepository,
        QuestionCategoryRepository $questionCategoryRepository,
        FormService $formValidationService
    )
    {
        $this->questionRepository = $questionRepository;
        $this->questionCategoryRepository = $questionCategoryRepository;
        $this->formValidationService = $formValidationService;
    }

    /**
     * Index action.
     *
     * @throws InvalidQueryException
     */
    public function indexAction(Faq $faq = null, bool $showAll = false): ResponseInterface
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

        $this->addSchemaOrgHeader($questions);

        if ($this->request->getQueryParams()['tx_faq_faq']['currentPage']) {
            $currentPage = intval($this->request->getQueryParams()['tx_faq_faq']['currentPage']);
        } else {
            $currentPage = 1;
        }

        $paginator = new QueryResultPaginator($questions, $currentPage, (int)$this->settings['faq']['limitPerPage']);
        $pagination = new SimplePagination($paginator);

        $this->view->assignMultiple([
            'showResults' => $showResults,
            'faq' => $faq,
            'questions' => $questions,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'pages' => range(1, $pagination->getLastPageNumber()),
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

        return $this->htmlResponse();
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
        $this->addSchemaOrgHeader($questions);
        $this->view->assign('questions', $questions);
    }

    /**
     * Render the detail action.
     */
    public function detailAction(Question $question): void
    {
        $this->addSchemaOrgHeader([$question]);
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
    public function sendAction(QuestionRequest $question, string $captcha = null): ResponseInterface
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
        return new ForwardResponse('user');
    }

    public function submitAction(): ResponseInterface
    {

        if($this->formValidationService->validate($this->request, QuestionFormFactory::class)) {
            $this->formValidationService->executeFinisher($this->request, QuestionFormFactory::class);
        }

        return new Response();
    }

    /**
     * user action.
     *
     * @throws StopActionException
     */
    public function userAction(QuestionRequest $question): ResponseInterface
    {
        if (GeneralUtility::validEmail($question->getEmail())) {
            $this->view->assignMultiple([
                'subject' => 'FAQ eingereicht',
                'to' => [$question->getEmail() => $question->getEmail()],
                'question' => $question,
            ]);
            $this->view->render();
        }
        return new ForwardResponse('thanks');
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

    protected function addSchemaOrgHeader(iterable $questions): void
    {
        if (!$this->settings['faq']['addSchmemaOrgHeader']) {
            return;
        }

        $additionalHeaderData = '
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "FAQPage",
            "mainEntity": [';
        foreach ($questions as $question) {
            $additionalHeaderData .= \str_replace([
                'QUESTION_TEXT',
                'CREATED',
                'ANSWER_TEXT',
            ],
                [
                    $question->getTitle(),
                    $question->getCrdate()->format('Y-m-d H:i:s'),
                    $question->getAnswer(),
                ],
                '{
                "@type": "Question",
                "name": "QUESTION_TEXT",
                "dateCreated": "CREATED",
                "acceptedAnswer": {
                    "@type": "answer",
                    "text": "ANSWER_TEXT",
                    "dateCreated": "CREATED"
                }
            },');
        }
        $additionalHeaderData = \substr($additionalHeaderData, 0, -1);
        $additionalHeaderData .= '
            ]
        }
        </script>';
        $this->response->addAdditionalHeaderData($additionalHeaderData);
    }
}
