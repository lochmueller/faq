<?php
/**
 * ext_localconf.php
 *
 * General file information
 *
 * @author     Tim Spiekerkoetter
 */

/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extLocalconf('HDNET', 'faq');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'Faq', array('Faq' => 'index,detail'), array('Faq' => 'index'));
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'FaqTeaser', array('Faq' => 'teaser'));
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'FaqEnter', array('Faq' => 'form,send,user,thanks'), array('Faq' => 'send,user,thanks'));

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['faqTopFlop'] = 'EXT:faq/Resources/Private/Php/FaqTopFlop.php';
