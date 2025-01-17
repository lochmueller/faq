<?php

declare(strict_types = 1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

\defined('TYPO3') || exit();

(static function (): void {
    $pluginKey = ExtensionUtility::registerPlugin(
        // extension name, matching the PHP namespaces (but without the vendor)
        'Faq',
        // arbitrary, but unique plugin name (not visible in the backend)
        'Faq',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'FAQ',
    );
    $pluginKey = ExtensionUtility::registerPlugin(
        // extension name, matching the PHP namespaces (but without the vendor)
        'Faq',
        // arbitrary, but unique plugin name (not visible in the backend)
        'FaqAll',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'FAQ All Categories',
    );
    $pluginKey = ExtensionUtility::registerPlugin(
        // extension name, matching the PHP namespaces (but without the vendor)
        'Faq',
        // arbitrary, but unique plugin name (not visible in the backend)
        'Question',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'FAQ Question Input',
    );
    $pluginKey = ExtensionUtility::registerPlugin(
        // extension name, matching the PHP namespaces (but without the vendor)
        'Faq',
        // arbitrary, but unique plugin name (not visible in the backend)
        'FaqSingleCategory',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'FAQ Single Category Selection',
    );
})();

$pluginSignature = str_replace('_', '', 'faq') . '_faq';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:faq/Configuration/FlexForms/Faq.xml');

$pluginSignature = str_replace('_', '', 'faq') . '_question';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:faq/Configuration/FlexForms/Question.xml');

$pluginSignature = str_replace('_', '', 'faq') . '_faqsinglecategory';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:faq/Configuration/FlexForms/FaqSingleCategory.xml');
