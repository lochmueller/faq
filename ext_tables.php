<?php
/**
 * ext_tables.php
 *
 * General file information
 *
 * @author     Tim Spiekerkoetter
 */

/** @var string $_EXTKEY */

\HDNET\Autoloader\Loader::extTables('HDNET', 'faq');

// Plugins
$plugins = array(
	'Faq'       => 'HDNET: FAQ',
	'FaqTeaser' => 'HDNET: FAQ Teaser',
	'FaqEnter'  => 'HDNET: FAQ Eingabe',
);
foreach ($plugins as $key => $description) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, $key, $description);
}
unset($plugins);
