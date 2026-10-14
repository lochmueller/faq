<?php

declare(strict_types = 1);

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

\defined('TYPO3') || exit();

(static function (): void {
    $isV14OrNewer = (new Typo3Version())->getMajorVersion() >= 14;

    $plugins = [
        'Faq' => [
            'title' => 'FAQ',
            'flexForm' => 'FILE:EXT:faq/Configuration/FlexForms/Faq.xml',
        ],
        'FaqAll' => [
            'title' => 'FAQ All Categories',
            'flexForm' => '',
        ],
        'Question' => [
            'title' => 'FAQ Question Input',
            'flexForm' => 'FILE:EXT:faq/Configuration/FlexForms/Question.xml',
        ],
        'FaqSingleCategory' => [
            'title' => 'FAQ Single Category Selection',
            'flexForm' => 'FILE:EXT:faq/Configuration/FlexForms/FaqSingleCategory.xml',
        ],
    ];

    foreach ($plugins as $pluginName => $plugin) {
        if ($isV14OrNewer) {
            // TYPO3 v14: registerPlugin() accepts the FlexForm directly and adds
            // the plugin tab together with the pi_flexform field on its own.
            ExtensionUtility::registerPlugin(
                'Faq',
                $pluginName,
                $plugin['title'],
                'extension-faq',
                'plugins',
                '',
                $plugin['flexForm'],
            );
            continue;
        }

        // TYPO3 v13.4: registerPlugin() does not accept a FlexForm yet, so it is
        // registered the classic way (see core EXT:felogin for the pattern).
        $contentType = ExtensionUtility::registerPlugin(
            'Faq',
            $pluginName,
            $plugin['title'],
            'extension-faq',
        );

        if ('' === $plugin['flexForm']) {
            continue;
        }

        ExtensionManagementUtility::addPiFlexFormValue('*', $plugin['flexForm'], $contentType);
        ExtensionManagementUtility::addToAllTCAtypes(
            'tt_content',
            '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin, pi_flexform',
            $contentType,
            'after:palette:headers',
        );
    }
})();
