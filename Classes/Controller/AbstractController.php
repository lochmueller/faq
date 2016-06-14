<?php
/**
 * AbstractController.php
 *
 * General file information
 *
 * @author     Tim Spiekerkoetter
 */

namespace HDNET\Faq\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * AbstractController
 *
 * General class information
 */
abstract class AbstractController extends ActionController
{

    /**
     * Initializes the view before invoking an action method.
     * Add content object data to view
     *
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view The view to be initialized
     * @return void
     */
    protected function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        $view->assign('contentObjectData', $this->configurationManager->getContentObject()->data);
        parent::initializeView($view);
    }

    /**
     * Disable indexing of this page
     */
    protected function disableIndexing()
    {
        if ($GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
            $GLOBALS['TSFE']->config['config']['index_enable'] = 0;
            $GLOBALS['TSFE']->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['pageIndexing'] = [];
            $GLOBALS['TSFE']->page['no_search'] = 1;
        }
    }
}
