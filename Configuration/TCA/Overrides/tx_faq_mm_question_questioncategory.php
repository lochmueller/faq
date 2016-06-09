<?php

/**
 * Base TCA generation for the table tx_faq_mm_question_questioncategory
 */

$GLOBALS['TCA']['tx_faq_mm_question_questioncategory'] = \HDNET\Autoloader\Utility\ModelUtility::getTcaOverrideInformation('faq',
    'tx_faq_mm_question_questioncategory');

$custom = [
    'ctrl' => [
        'hideTable' => true,
    ],
];

$GLOBALS['TCA']['tx_faq_mm_question_questioncategory'] = \HDNET\Autoloader\Utility\ArrayUtility::mergeRecursiveDistinct($GLOBALS['TCA']['tx_faq_mm_question_questioncategory'],
    $custom);
