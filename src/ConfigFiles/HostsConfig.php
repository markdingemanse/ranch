<?php

namespace Liquidpineapple\Ranch\ConfigFiles;

use Liquidpineapple\Ranch\Config;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class HostsConfig implements ConfigInterface {

    private $filePath;
    private $fs;

    public function __construct()
    {
        $this->fs = new Filesystem;
        $this->filePath = Config::hostsFile();
    }

    public function asArray()
    {
        if ($this->fs->exists($this->filePath)) {
            return $this->parse(file_get_contents($this->filePath));
        } else {
            return [];
        }
    }

    private function parse($content)
    {
        
    }

}
