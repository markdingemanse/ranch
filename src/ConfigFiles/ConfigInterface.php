<?php

namespace Liquidpineapple\Ranch\ConfigFiles;

use Illuminate\Support\Collection;

interface ConfigInterface {

    /**
     * Returns config file as array
     * @return Collection Array of config values
     */
    public static function get();

    /**
     * Saves the given config
     * @param $config Collection Configuration to save
     */
     public static function save(array $config);
}
