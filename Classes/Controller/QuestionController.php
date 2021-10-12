<?php

declare(strict_types = 1);

namespace HDNET\Faq\Controller;

use HDNET\Autoloader\Annotation\NoCache;
use HDNET\Autoloader\Annotation\Plugin;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

class QuestionController extends AbstractController
{

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
        return new ForwardResponse('index');
    }
}
