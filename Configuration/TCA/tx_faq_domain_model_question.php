<?php
$base = \HDNET\Autoloader\Utility\ModelUtility::getTcaInformation('HDNET\\Faq\\Domain\\Model\\Question');

$custom = array(
    'ctrl'    => array(
        'sortby' => null,
    ),
    'columns' => array(
        'title'     => array(
            'config'        => array(
                'eval' => 'trim,required'
            ),
        ),
        'answer'     => array(
            'config'        => array(
                'type' => 'text'
            ),
            'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]',
        ),
        'categories' => array(
            'config' => array(
                'type'          => 'select',
                'renderType'    => 'selectTree',
                'foreign_table' => 'tx_faq_domain_model_questioncategory',
                'maxitems'      => '999',
                'minitems'      => '1',
                'MM'            => 'tx_faq_mm_question_questioncategory',
                'renderMode'    => 'tree',
                'treeConfig'    => array(
                    'parentField' => 'parent',
                ),
            ),
        ),
    ),
);

return \HDNET\Autoloader\Utility\ArrayUtility::mergeRecursiveDistinct($base, $custom);