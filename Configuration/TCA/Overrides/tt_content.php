<?php

declare(strict_types=1);

use HDNET\Autoloader\Utility\ModelUtility;

$GLOBALS['TCA']['tt_content'] = ModelUtility::getTcaOverrideInformation('faq', 'tt_content');
