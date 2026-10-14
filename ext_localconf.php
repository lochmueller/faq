<?php

defined('TYPO3') or die();

use HDNET\Faq\Controller\FaqController;
use HDNET\Faq\Controller\QuestionController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::configurePlugin(
    'Faq', // Extension name
    'Faq', // Plugin name
    // all actions
    [
        FaqController::class => 'index',
    ],
    // Non-cacheable actions
    [
        FaqController::class => 'index',
    ],
    // Register as content element (CType)
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Faq', // Extension name
    'FaqAll', // Plugin name
    // all actions
    [
        FaqController::class => 'all',
    ],
    // Non-cacheable actions
    [
        FaqController::class => 'all',
    ],
    // Register as content element (CType)
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Faq', // Extension name
    'Question', // Plugin name
    // all actions
    [
        QuestionController::class => 'index, submit',
    ],
    // Non-cacheable actions
    [
        QuestionController::class => 'submit',
    ],
    // Register as content element (CType)
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Faq', // Extension name
    'FaqSingleCategory', // Plugin name
    // all actions
    [
        FaqController::class => 'singleCategory',
    ],
    // Non-cacheable actions
    [
        FaqController::class => 'singleCategory',
    ],
    // Register as content element (CType)
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
