<?php
/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extTables('HDNET', 'faq', \HDNET\Faq\Utility\ExtensionUtility::getAutoloaderConfiguration());

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
