<?php

$loader = array(
    'SmartObjects',
    'ExtensionTypoScriptSetup',
    'ContextSensitiveHelps',
    'FlexForms',
    'StaticTyposcript',
    'ExtensionId',
);
\HDNET\Autoloader\Loader::extTables('HDNET', 'faq', $loader);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'Faq', 'FAQ');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'FaqTeaser', 'FAQ Teaser');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'FaqEnter', 'FAQ Eingabe');