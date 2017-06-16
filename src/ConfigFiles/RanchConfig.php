<?php

namespace Liquidpineapple\Ranch\ConfigFiles;

use Illuminate\Support\Collection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class RanchConfig implements ConfigInterface {

    /**
     * Returns config file as array
     * @return array Array of config values
     */
    public static function get()
    {
        $fs = new Filesystem;
        $filePath = getenv('HOME'). '/.ranchcfg';
        if ($fs->exists($filePath)) {
            return self::parse(file_get_contents($filePath));
        } else {
            return [];
        }
    }

    /**
     * Saves the given config
     * @param $config array Configuration to save
     */
    public static function save(Collection $config)
    {
        // file_put_contents($filePath, $this->dump($config));
    }

    /**
     * Parse the raw configuration file contents
     * @param $content string Raw file contents
     * @return array Parsed config content
     */
    private static function parse($content)
    {
        $lines = explode(PHP_EOL, $content);
        $parsedConfig = [];
        foreach ($lines as $line) {
            if (count(explode('=', $line)) >= 2) {
                $key = explode('=', $line)[0];
                $value = explode('=', $line)[1];
                // Convert snakecase to camelcase
                $segments = explode('_', $key);
                $segments = array_map('strtolower', $segments);
                for ($i=1; $i<count($segments); $i++) {
                    $segments[$i] = ucfirst($segments[$i]);
                }
                $key = implode($segments);

                $parsedConfig[$key] = $value;
            }
        }
        return new Collection($parsedConfig);
    }

    /**
     * Generates raw config file content form array
     * @param $config array Configuration
     * @return string Raw file content
     */
    private static function dump($config)
    {
        //.
    }

}
