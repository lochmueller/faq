<?php

declare(strict_types = 1);

use HDNET\Faq\Domain\Model\Question;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$base = [
    'ctrl' => [
        'title' => 'LLL:EXT:faq/Resources/Private/Language/locallang_db.xlf:tx_faq_domain_model_question',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,answer',
        'iconfile' => 'EXT:faq/Resources/Public/Icons/tx_faq_domain_model_question.svg',
    ],
];

$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('faq');
$enableManuallySorting = $extensionConfiguration['enableManuallySorting'] ?? false;

$custom = [
    'ctrl' => [
        'sortby' => $enableManuallySorting ? 'sorting' : null,
    ],
    'columns' => [
        'title' => [
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'answer' => [
            'config' => [
                'type' => 'text',
            ],
        ],
        'categories' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'foreign_table_where' => 'tx_faq_domain_model_questioncategory.sys_language_uid IN (0,-1)',
                'maxitems' => 999,
                'minitems' => 1,
                'MM' => 'tx_faq_mm_question_questioncategory',
                'renderMode' => 'tree',
                'treeConfig' => [
                    'parentField' => 'parent',
                ],
            ],
        ],
        '_languageUid' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'crdate' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];

return array_merge_recursive($base, $custom);
