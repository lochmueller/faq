<?php

declare(strict_types = 1);

use HDNET\Faq\Domain\Model\QuestionCategory;

$base = [
    'ctrl' => [
        'title' => 'FAQ Category',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'iconfile' => 'EXT:faq/Resources/Public/Icons/category.svg',
    ],
    'columns' => [
        'title' => [
            'label' => 'Category Title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'answer' => [
            'label' => 'Answer',
            'config' => [
                'type' => 'text',
            ],
        ],
        'parent' => [
            'label' => 'Parent Category',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'treeConfig' => [
                    'parentField' => 'parent',
                ],
                'default' => 0,
            ],
        ],
        '_languageUid' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];

$custom = [
    'columns' => [
        'answer' => [
            'config' => [
                'type' => 'text',
            ],
        ],
        'parent' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'foreign_table_where' => 'tx_faq_domain_model_questioncategory.sys_language_uid IN (0,-1)',
                'maxitems' => 1,
                'minitems' => 0,
                'default' => 0,
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
    ],
];

return array_merge_recursive($base, $custom);
