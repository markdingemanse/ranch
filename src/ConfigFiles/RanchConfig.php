<?php

namespace Liquidpineapple\Ranch\ConfigFiles;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class RanchConfig implements ConfigInterface {

    private $filePath;
    private $fs;

    public function __construct()
    {
        $this->fs = new Filesystem;
        $this->filePath = getenv('HOME'). '/.ranchcfg';
    }

    /**
     * Returns config file as array
     * @return array Array of config values
     */
    public function asArray()
    {
        if ($this->fs->exists($this->filePath)) {
            return $this->parse(file_get_contents($this->filePath));
        } else {
            return [];
        }
    }

    /**
     * Saves the given config
     * @param $config array Configuration to save
     */
    public function save($config)
    {
        // file_put_contents($this->filePath, $this->dump($config));
    }

    /**
     * Parse the raw configuration file contents
     * @param $content string Raw file contents
     * @return array Parsed config content
     */
    private function parse($content)
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
        return $parsedConfig;
    }

    /**
     * Generates raw config file content form array
     * @param $config array Configuration
     * @return string Raw file content
     */
    private function dump($config)
    {
        //
    }

}
