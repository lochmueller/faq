<?php
/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extLocalconf(
    'HDNET',
    'faq',
    \HDNET\Faq\Utility\ExtensionUtility::getAutoloaderConfiguration()
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'HDNET.faq',
    'Faq',
    ['Faq' => 'index,detail'],
    ['Faq' => 'index']
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'HDNET.faq',
    'FaqTeaser',
    ['Faq' => 'teaser']
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'HDNET.faq',
    'FaqEnter',
    ['Faq' => 'form,send,user,thanks'],
    ['Faq' => 'send,user,thanks']
);
