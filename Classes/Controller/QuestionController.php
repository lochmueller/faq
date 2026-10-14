<?php

declare(strict_types = 1);

namespace HDNET\Faq\Controller;

use HDNET\Faq\Domain\Factory\QuestionFormFactory;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class QuestionController extends ActionController
{
    public function __construct(protected readonly QuestionFormFactory $questionFormFactory)
    {
    }

    public function indexAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    public function submitAction(): ResponseInterface
    {
        return new ForwardResponse('index');
    }
}
