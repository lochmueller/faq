<?php
/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extLocalconf(
    'HDNET',
    'faq',
    \HDNET\Faq\Utility\ExtensionUtility::getAutoloaderConfiguration()
);

//\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
//    'faq',
//    'Faq',
//    [\HDNET\Faq\Controller\FaqController::class => 'index'],
//    [\HDNET\Faq\Controller\FaqController::class => 'index']
//);
//
//\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
//    'faq',
//    'FaqEnter',
//    [\HDNET\Faq\Controller\FaqController::class => 'form,send,user,thanks,submit'],
//    [\HDNET\Faq\Controller\FaqController::class => 'send,user,thanks,submit']
//);
