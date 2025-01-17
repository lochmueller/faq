<?php

declare(strict_types = 1);

namespace HDNET\Faq\Utility;

/**
 * ExtensionUtility.
 */
class ExtensionUtility
{
    /**
     * Get the autoloader configuration.
     */
    public static function getAutoloaderConfiguration(): array
    {
        return [
            'SmartObjects',
            'ExtensionTypoScriptSetup',
            'FlexForms',
            'StaticTyposcript',
            'ExtensionId',
            'Plugins',
        ];
    }
}
