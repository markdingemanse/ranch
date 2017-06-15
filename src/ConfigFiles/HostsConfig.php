<?php

namespace Liquidpineapple\Ranch\ConfigFiles;

use Liquidpineapple\Ranch\Config;
use Illuminate\Support\Collection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class HostsConfig implements ConfigInterface {

    /**
     * Returns a collction with all configured sites
     * @return Collection list of sites
     */
    public static function getSites()
    {
        return HostsConfig::get()
            ->filter(function($host) {
                return $host['ip_address'] === Config::homesteadIp();
            })
            ->map(function($host) {
                return $host['hostname'];
            })
            ->sort();
    }

    public static function get()
    {
        $fs = new Filesystem;
        $filePath = Config::hostsFile();

        if ($fs->exists($filePath)) {
            return self::parse(file_get_contents($filePath));
        } else {
            throw new Exception('Could not find Hosts file');
        }
    }

    public static function save(Collection $config)
    {
        //.
    }

    private static function parse($content)
    {
        $lines = new Collection(explode(PHP_EOL, $content));
        return $lines->filter(function($line) {return substr($line, 0, 1) !== '#';})
                     ->filter(function($line) {return $line !== '';})
                     ->map(function($line) {
                         $segments = explode("\t", $line, 2);
                         if (count($segments) == 1) {
                             $segments = explode(" ", $line, 2);
                         }
                         $segments = array_map('trim', $segments);
                         return [
                             'ip_address' => $segments[0],
                             'hostname' => $segments[1],
                         ];
                     });
    }

    private static function dump()
    {

    }

}
