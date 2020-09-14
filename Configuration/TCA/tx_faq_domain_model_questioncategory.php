<?php

declare(strict_types = 1);
use HDNET\Autoloader\Utility\ArrayUtility;
use HDNET\Autoloader\Utility\ModelUtility;
use HDNET\Faq\Domain\Model\QuestionCategory;

$base = ModelUtility::getTcaInformation(QuestionCategory::class);

$custom = [
    'columns' => [
        'parent' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
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

return ArrayUtility::mergeRecursiveDistinct($base, $custom);
