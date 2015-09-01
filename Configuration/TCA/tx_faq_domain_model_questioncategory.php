<?php
$base = \HDNET\Autoloader\Utility\ModelUtility::getTcaInformation('HDNET\\Faq\\Domain\\Model\\Questioncategory');

$custom = array(
	'columns' => array(
		'parent' => array(
			'config' => array(
				'type'          => 'select',
				'foreign_table' => 'tx_faq_domain_model_questioncategory',
				'maxitems'      => '1',
				'minitems'      => '0',
				'renderMode'    => 'tree',
				'treeConfig'    => array(
					'parentField' => 'parent',
				),
			),
		),
	),
);

return \HDNET\Autoloader\Utility\ArrayUtility::mergeRecursiveDistinct($base, $custom);