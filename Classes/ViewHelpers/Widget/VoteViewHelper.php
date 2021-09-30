<?php

declare(strict_types = 1);
/**
 * VoteViewHelper.php.
 */

namespace HDNET\Faq\ViewHelpers\Widget;

use HDNET\Faq\ViewHelpers\Widget\Controller\VoteController;
use TYPO3\CMS\Extbase\Mvc\ResponseInterface;
use TYPO3\CMS\Fluid\Core\Widget\Exception\MissingControllerException;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * VoteViewHelper.
 * @deprecated
 */
class VoteViewHelper extends AbstractWidgetViewHelper
{
    /**
     * AJAX Widget?
     *
     * @var bool
     */
    protected $ajaxWidget = true;

    /**
     * Controller.
     *
     * @var VoteController
     */
    protected $controller;

    public function __construct(VoteController $voteController)
    {
        $this->controller = $voteController;
    }

    /**
     * Initialize arguments.
     *
     * @throws Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('question', 'int', '', true);
        $this->registerArgument('counters', 'array', '', true);
    }

    /**
     * Render.
     *
     * @throws MissingControllerException
     *
     * @return ResponseInterface
     */
    public function render()
    {
        return $this->initiateSubRequest();
    }
}
