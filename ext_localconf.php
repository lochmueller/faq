<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use HDNET\Faq\Controller\QuestionController;
use HDNET\Faq\Controller\FaqController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Information\Typo3Version;

ExtensionUtility::configurePlugin(
    'Faq', // Extension name
    'Faq', // Plugin name
    // all actions
    [
        QuestionController::class => 'index, submit',
        FaqController::class => 'index, all, singleCategory',
    ],
    // Non-cacheable actions
    [
        QuestionController::class => 'submit',
        FaqController::class => 'all, singleCategory',
    ]
);

/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);

$iconRegistry->registerIcon(
    'contains-faq',
    BitmapIconProvider::class,
    ['source' => 'EXT:faq/Resources/Public/Icons/contains-faq.png']
);

$iconRegistry->registerIcon(
    'apps-pagetree-folder-contains-faq',
    BitmapIconProvider::class,
    ['source' => 'EXT:faq/Resources/Public/Icons/apps-pagetree-folder-contains-faq.png']
);

$iconRegistry->registerIcon(
    'extension-faq',
    BitmapIconProvider::class,
    ['source' => 'EXT:faq/Resources/Public/Icons/extension-faq.png']
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

// if ((new Typo3Version())->getMajorVersion() < 12) {
//    ExtensionManagementUtility::addPageTSConfig('
//       @import \'EXT:faq/Configuration/TSconfig/ContentElementWizard.tsconfig\'
//    ');
// }