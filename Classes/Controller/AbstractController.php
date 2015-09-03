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
     * Disable indexing of this page
     */
    protected function disableIndexing()
    {
        if ($GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
            $GLOBALS['TSFE']->config['config']['index_enable'] = 0;
            $GLOBALS['TSFE']->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['pageIndexing'] = array();
            $GLOBALS['TSFE']->page['no_search'] = 1;
        }
    }
}
