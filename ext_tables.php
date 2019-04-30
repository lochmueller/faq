<?php
/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extTables('HDNET', 'faq', \HDNET\Faq\Utility\ExtensionUtility::getAutoloaderConfiguration());

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'Faq', 'FAQ');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'FaqTeaser', 'FAQ Teaser');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'FaqEnter', 'FAQ Eingabe');

// module icon
$extensionIcon = \HDNET\Autoloader\Utility\IconUtility::getByExtensionKey('faq', true);
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'apps-pagetree-folder-contains-faq',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => $extensionIcon]
);
$iconRegistry->registerIcon(
    'contains-faq',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => $extensionIcon]
);

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
