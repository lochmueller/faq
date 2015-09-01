<?php
$base = \HDNET\Autoloader\Utility\ModelUtility::getTcaInformation('HDNET\\HdnetFaq\\Domain\\Model\\Question');

$custom = array(
	'ctrl'    => array(
		'sortby' => NULL,
	),
	'columns' => array(
		'answer'     => array(
			'config'        => array(
				'type' => 'text'
			),
			'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts_css]',
		),
		'categories' => array(
			'config' => array(
				'type'          => 'select',
				'foreign_table' => 'tx_hdnetfaq_domain_model_questioncategory',
				'maxitems'      => '999',
				'minitems'      => '1',
				'MM'            => 'tx_hdnetfaq_mm_question_questioncategory',
				'renderMode'    => 'tree',
				'treeConfig'    => array(
					'parentField' => 'parent',
				),
			),
		),
	),
);

return \HDNET\Autoloader\Utility\ArrayUtility::mergeRecursiveDistinct($base, $custom);