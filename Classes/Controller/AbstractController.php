<?php

declare(strict_types = 1);

namespace HDNET\Faq\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

abstract class AbstractController extends ActionController
{
    /**
     * Initializes the view before invoking an action method.
     * Add content object data to view.
     */
    protected function initializeView(): void
    {
        $this->view->assign('contentObjectData', $this->configurationManager->getContentObject()->data);
    }

    /**
     * Disable indexing of this page.
     */
    protected function disableIndexing()
    {
        if ($GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
            $GLOBALS['TSFE']->config['config']['index_enable'] = 0;
            $GLOBALS['TSFE']->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-cached'] = [];
            $GLOBALS['TSFE']->page['no_search'] = 1;
        }
    }
}
