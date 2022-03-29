<?php

use HDNET\Autoloader\Utility\IconUtility;
use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;

$baseIcon = IconUtility::getByExtensionKey('faq', true);

return [
    'contains-faq' => [
        'provider' => BitmapIconProvider::class,
        'source' => $baseIcon,
    ],
    'apps-pagetree-folder-contains-faq' => [
        'provider' => BitmapIconProvider::class,
        'source' => $baseIcon,
    ],
    'extension-faq' => [
        'provider' => BitmapIconProvider::class,
        'source' => $baseIcon,
    ],
];

