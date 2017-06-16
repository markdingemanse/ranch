<?php

namespace Liquidpineapple\Ranch\ConfigFiles;

use Exception;
use Illuminate\Support\Collection;
use Liquidpineapple\Ranch\Config;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class HomesteadConfig implements ConfigInterface {

    public static function getRemoteSyncPaths()
    {
        $config = self::get();
        return collect($config['folders'])
            ->map(function($folder) {
                return $folder['to'];
            });
    }

    public static function getRemoteSitePaths()
    {
        $config = self::get();
        return collect($config['sites'])
            ->map(function($site) {
                return $site['to'];
            });
    }

    /**
     * Returns a collction with all configured sites
     * @return Collection list of sites
     */
    public static function getSites()
    {
        $config = self::get();
        return collect($config['sites'])
            ->map(function($site) {
                return $site['map'];
            })
            ->sort();
    }

    /**
     * Returns config file as array
     * @return array Array of config values
     */
    public static function get()
    {
        $fs = new Filesystem;
        $filePath = Config::homesteadDir() . '/Homestead.yaml';

        if ($fs->exists($filePath)) {
            return self::parse(file_get_contents($filePath));
        } else {
            throw new Exception('Could not find Homestead.yaml');
        }
    }

    /**
     * Saves the given config
     * @param $config array Configuration to save
     */
    public static function save(array $config)
    {
        $filePath = Config::homesteadDir() . '/Homestead.yaml';
        file_put_contents($filePath, $this->dump($config));
    }

    /**
     * Parse the raw configuration file contents
     * @param $content string Raw file contents
     * @return array Parsed config content
     */
    private static function parse($content)
    {
        return Yaml::parse($content);
    }

    /**
     * Generates raw config file content form array
     * @param $config array Configuration
     * @return string Raw file content
     */
    private static function dump($config)
    {
        return Yaml::dump($config);
    }
}
