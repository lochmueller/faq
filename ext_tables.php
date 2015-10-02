<?php
/** @var string $_EXTKEY */

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

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][$_EXTKEY]['0'] = 'LLL:EXT:faq/Resources/Private/Language/locallang.xml:sysfolder';
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][$_EXTKEY]['1'] = $_EXTKEY;

\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', 'contains-faq',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/QuestionFolder.png');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
mod {
	wizards.newContentElement.wizardItems.plugins {
		elements {
			faq {
				icon = EXT:faq/Resources/Public/Icons/Question.png
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