<?php
$base = \HDNET\Autoloader\Utility\ModelUtility::getTcaInformation('HDNET\\Faq\\Domain\\Model\\Questioncategory');

$custom = [
    'columns' => [
        'parent' => [
            'config' => [
                'type'          => 'select',
                'renderType'    => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'maxitems'      => '1',
                'minitems'      => '0',
                'renderMode'    => 'tree',
                'treeConfig'    => [
                    'parentField' => 'parent',
                ],
            ],
        ],
    ],
];

return \HDNET\Autoloader\Utility\ArrayUtility::mergeRecursiveDistinct($base, $custom);
