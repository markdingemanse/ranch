<?php

namespace Liquidpineapple\Ranch\ConfigFiles;

interface ConfigInterface {

    /**
     * Returns config file as array
     * @return array Array of config values
     */
    public function asArray();

    /**
     * Saves the given config
     * @param $config array Configuration to save
     */
     public function save($config);
}
