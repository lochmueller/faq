<?php

declare(strict_types = 1);

namespace HDNET\Faq\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use HDNET\Faq\Domain\Factory\QuestionFormFactory;

class QuestionController extends AbstractController
{
    protected QuestionFormFactory $questionFormFactory;

    public function __construct(QuestionFormFactory $questionFormFactory)
    {
        $this->questionFormFactory = $questionFormFactory;
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
