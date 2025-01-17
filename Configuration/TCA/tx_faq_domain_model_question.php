<?php

declare(strict_types = 1);

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('faq');
$enableManuallySorting = $extensionConfiguration['enableManuallySorting'] ?? false;

return [
    'ctrl' => [
        'title' => 'LLL:EXT:faq/Resources/Private/Language/locallang_be.xlf:tx_faq_domain_model_question',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title',
        'iconfile' => 'EXT:faq/Resources/Public/Icons/Question.png',
        'sortby' => $enableManuallySorting ? 'sorting' : null,
    ],
    'types' => [
        '1' => [
            'showitem' => implode(
                ',',
                [
                    'title, answer, tags, categories',
                    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language',
                    'sys_language_uid',
                    'l10n_diffsource',
                    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access',
                    'hidden',
                    'starttime',
                    'endtime',
                ]
            ),
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'foreign_table_where' => 'AND {#tx_faq_domain_model_questioncategory}.{#pid}=###CURRENT_PID### AND {#tx_faq_domain_model_questioncategory}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'value' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'crdate' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'tstamp' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.timestamp',
            'config' => [
                'type' => 'datetime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],

        'title' => [
            'label' => 'LLL:EXT:faq/Resources/Private/Language/locallang_be.xlf:tx_faq_domain_model_question.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'answer' => [
            'label' => 'LLL:EXT:faq/Resources/Private/Language/locallang_be.xlf:tx_faq_domain_model_question.answer',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
                'softref' => 'typolink_tag,email[subst],url',
                'enableRichtext' => true,
            ],
        ],
        'tags' => [
            'label' => 'LLL:EXT:faq/Resources/Private/Language/locallang_be.xlf:tx_faq_domain_model_question.tags',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'categories' => [
            'label' => 'LLL:EXT:faq/Resources/Private/Language/locallang_be.xlf:tx_faq_domain_model_question.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'MM' => 'tx_faq_mm_question_questioncategory',
                'foreign_table_where' => 'AND tx_faq_domain_model_questioncategory.sys_language_uid IN (-1, 0) ORDER BY tx_faq_domain_model_questioncategory.title',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => true,
                        'showHeader' => true,
                    ],
                ],
                'minitems' => 0,
                'maxitems' => 99,
                'default' => 0,
                'required' => true,
            ],
        ],
    ],
];
