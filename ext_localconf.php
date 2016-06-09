<?php
/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extLocalconf('HDNET', 'faq',
    \HDNET\Faq\Utility\ExtensionUtility::getAutoloaderConfiguration());

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'Faq', ['Faq' => 'index,detail'],
    ['Faq' => 'index']);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'FaqTeaser',
    ['Faq' => 'teaser']);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'FaqEnter',
    ['Faq' => 'form,send,user,thanks'], ['Faq' => 'send,user,thanks']);
