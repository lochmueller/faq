<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'contains-faq' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:faq/Resources/Public/Icons/QuestionFolder.svg',
    ],
    'apps-pagetree-folder-contains-faq' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:faq/Resources/Public/Icons/QuestionFolder.svg',
    ],
    'extension-faq' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:faq/Resources/Public/Icons/Question.svg',
    ],
];
