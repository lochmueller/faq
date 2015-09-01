<?php
/**
 * AbstractController.php
 *
 * General file information
 *
 * @author     Tim Spiekerkoetter
 */

namespace HDNET\Faq\Controller;

use HDNET\Hdnet\Controller\AbstractController as HdnetAbstractController;
use HDNET\Hdnet\Xclass\TypoScriptFrontendController;

/**
 * AbstractController
 *
 * General class information
 */
abstract class AbstractController extends HdnetAbstractController {
	/**
	 * Disable indexing of this page
	 */
	protected function disableIndexing() {
		if ($GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
			$GLOBALS['TSFE']->config['config']['index_enable'] = 0;
			$GLOBALS['TSFE']->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['pageIndexing'] = array();
			$GLOBALS['TSFE']->page['no_search'] = 1;
		}
	}
}
