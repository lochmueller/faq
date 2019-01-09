<?php
/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extTables('HDNET', 'faq', \HDNET\Faq\Utility\ExtensionUtility::getAutoloaderConfiguration());

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'Faq', 'FAQ');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'FaqTeaser', 'FAQ Teaser');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'FaqEnter', 'FAQ Eingabe');

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][$_EXTKEY]['0'] = 'LLL:EXT:faq/Resources/Private/Language/locallang.xlf:sysfolder';
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][$_EXTKEY]['1'] = $_EXTKEY;

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'contains-faq',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:faq/Resources/Public/Icons/QuestionFolder.png']
);
$iconRegistry->registerIcon(
    'ext-faq-question',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:faq/Resources/Public/Icons/Question.png']
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
mod {
	wizards.newContentElement.wizardItems.plugins {
		elements {
			faq {
				iconIdentifier = ext-faq-question
				title = FAQ
				description = Create FAQ Plugin to handle the FAQ output
				tt_content_defValues {
					CType = list
					list_type = faq_faq
				}
			}
		}
	}
}
');
