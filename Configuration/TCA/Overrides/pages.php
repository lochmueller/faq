<?php

declare(strict_types = 1);

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][$_EXTKEY] = [
    'LLL:EXT:faq/Resources/Private/Language/locallang.xlf:sysfolder',
    $_EXTKEY,
    'contains-faq',
];
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-faq'] = 'apps-pagetree-folder-contains-faq';
