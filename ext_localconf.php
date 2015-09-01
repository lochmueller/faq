<?php

$loader = array(
    'SmartObjects',
    'ExtensionTypoScriptSetup',
    'ContextSensitiveHelps',
    'FlexForms',
    'StaticTyposcript',
    'ExtensionId',
);
\HDNET\Autoloader\Loader::extLocalconf('HDNET', 'faq', $loader);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'Faq', array('Faq' => 'index,detail'),
    array('Faq' => 'index'));
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'FaqTeaser', array('Faq' => 'teaser'));
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('HDNET.' . $_EXTKEY, 'FaqEnter',
    array('Faq' => 'form,send,user,thanks'), array('Faq' => 'send,user,thanks'));