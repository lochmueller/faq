<?php


namespace HDNET\Faq\Controller;


use HDNET\Faq\Domain\Factory\QuestionFormFactory;
use HDNET\Autoloader\Annotation\Plugin;
use HDNET\Autoloader\Annotation\NoCache;
use HDNET\Faq\Service\FormService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Validation\Error;

class QuestionController extends AbstractController
{
    /**
     * @var FormService
     */
    protected $formValidationService;

    public function __construct(
        FormService $formValidationService
    )
    {
        $this->formValidationService = $formValidationService;
    }

    /**
     * @Plugin("Question")
     */
    public function indexAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * @Plugin("Question")
     * @NoCache
     */
    public function submitAction(): ResponseInterface
    {
        if($this->formValidationService->validate($this->request, QuestionFormFactory::class)) {
            $this->formValidationService->executeFinisher($this->request, QuestionFormFactory::class);
        } else {
            foreach ($this->formValidationService->getErrors() as $identifier => $fieldErrors) {
                /** @var Error $fieldError */
                foreach ($fieldErrors as $fieldError) {
                    $this->addFlashMessage(ucfirst($identifier) . ': ' . $fieldError->getMessage());
                }
            }

        }
        return $this->redirect('index');
    }


}
