<?php

/**
 * ExtensionUtility
 */

namespace HDNET\Faq\Utility;

/**
 * ExtensionUtility
 */
class ExtensionUtility
{

    /**
     * Get the autoloader configuration
     *
     * @return array
     */
    static public function getAutoloaderConfiguration()
    {
        return [
            'SmartObjects',
            'ExtensionTypoScriptSetup',
            'FlexForms',
            'StaticTyposcript',
            'ExtensionId',
        ];
    }
}
