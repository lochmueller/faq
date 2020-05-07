<?php

declare(strict_types = 1);

$GLOBALS['TCA']['pages']['columns']['module']['config']['items']['faq'] = [
    'LLL:EXT:faq/Resources/Private/Language/locallang.xlf:sysfolder',
    'faq',
    'contains-faq',
];
$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-faq'] = 'apps-pagetree-folder-contains-faq';
