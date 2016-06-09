<?php
/**
 * VoteViewHelper.php
 *
 * @package    Hdnet
 * @author     Tim Spiekerkoetter
 */

namespace HDNET\Faq\ViewHelpers\Widget;

/**
 * VoteViewHelper
 *
 * @author     Tim Spiekerkoetter
 */
class VoteViewHelper extends AbstractWidgetViewHelper
{

    /**
     * @var bool
     */
    protected $ajaxWidget = true;

    /**
     * @var \HDNET\Faq\ViewHelpers\Widget\Controller\VoteController
     * @inject
     */
    protected $controller;

    /**
     * @param int $question
     * @param array $counters
     *
     * @return \TYPO3\CMS\Extbase\Mvc\ResponseInterface
     * @throws \TYPO3\CMS\Fluid\Core\Widget\Exception\MissingControllerException
     */
    public function render($question, array $counters)
    {
        return $this->initiateSubRequest();
    }
}
