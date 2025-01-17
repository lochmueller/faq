<?php

declare(strict_types = 1);
\defined('TYPO3') || exit();

\call_user_func(function () {
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'faq',
        'Configuration/TypoScript',
        'FAQ Extension'
    );
});
