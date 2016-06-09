<?php
$base = \HDNET\Autoloader\Utility\ModelUtility::getTcaInformation('HDNET\\Faq\\Domain\\Model\\Question');

$custom = [
    'ctrl'    => [
        'sortby' => null,
    ],
    'columns' => [
        'title'     => [
            'config'        => [
                'eval' => 'trim,required'
            ],
        ],
        'answer'     => [
            'config'        => [
                'type' => 'text'
            ],
            'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]',
        ],
        'categories' => [
            'config' => [
                'type'          => 'select',
                'renderType'    => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'maxitems'      => '999',
                'minitems'      => '1',
                'MM'            => 'tx_faq_mm_question_questioncategory',
                'renderMode'    => 'tree',
                'treeConfig'    => [
                    'parentField' => 'parent',
                ],
            ],
        ],
    ],
];

return \HDNET\Autoloader\Utility\ArrayUtility::mergeRecursiveDistinct($base, $custom);
