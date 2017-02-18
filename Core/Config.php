<?php

class Core_Config {

    public $config_path;
    public $config;

    public function __construct()
    {
        $this->configPath = 'Core/config.ini';
        $this->config = parse_ini_file($this->configPath, true);
    }

    public function getConfig() {
        return $this->config;
    }
}