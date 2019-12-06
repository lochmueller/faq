<?php

declare(strict_types = 1);
/**
 * VoteViewHelper.php.
 */

namespace HDNET\Faq\ViewHelpers\Widget;

/**
 * VoteViewHelper.
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
     * @var \HDNET\Faq\ViewHelpers\Widget\Controller\VoteController
     * @inject
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $controller;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
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
     * @throws \TYPO3\CMS\Fluid\Core\Widget\Exception\MissingControllerException
     *
     * @return \TYPO3\CMS\Extbase\Mvc\ResponseInterface
     */
    public function render()
    {
        return $this->initiateSubRequest();
    }
}
