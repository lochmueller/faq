<?php

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use HDNET\Faq\Controller\QuestionController;
use HDNET\Faq\Controller\FaqController;

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
    ]
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
    ]
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
    ]
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
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
mod {
	wizards.newContentElement.wizardItems.plugins {
		elements {
			faq {
			    iconIdentifier = extension-faq
				title = LLL:EXT:faq/Resources/Private/Language/locallang.xlf:plugin.Faq
				description = Create FAQ Plugin to handle the FAQ output
				tt_content_defValues {
					CType = list
					list_type = faq_faq
				}
			}
			faq_all_category {
			    iconIdentifier = extension-faq
				title = LLL:EXT:faq/Resources/Private/Language/locallang.xlf:plugin.FaqAll
				description = Create FAQ Plugin to handle the FAQ output incl. all the categories
				tt_content_defValues {
					CType = list
					list_type = faq_faqall
				}
			}
		}
	}
}
');
