<?php

namespace Liquidpineapple\Ranch;

class Config {

    /**
     * Retreives the user config file and returns it as a simple object
     */
    private static function getUserConfig()
    {
        return [

        ];
    }

    /**
     * Returns a simple object with a fallback configuration for
     * when the user configuration is not, or partially defined.
     */
    private static function getDefaultConfig()
    {
        return [
            'homedir' => $_SERVER['HOME'],
        ];
    }

    /**
     * Handles the retrieval of config values by using the
     * __callStatic magic method.
     * @param $name In this case the name of the config key
     * @param $args Arguments, in this case not used.
     * @return array|null If the key has a value it will get
     *                    returned as an array, of not: null
     */
    public static function __callStatic($name, $args)
    {
        $userConfig = self::getUserConfig();
        $defaultConfig = self::getDefaultConfig();
        if (isset($userConfig[$name])) {
            return $userConfig[$name];
        }
        if (isset($defaultConfig[$name])) {
            return $defaultConfig[$name];
        }
        return null;
    }
}
