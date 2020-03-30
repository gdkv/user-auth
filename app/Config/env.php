<?php
    namespace Config;

    /**
     * Class Env
     * Читаем файл config.php и разбиваем его на переменные окружения
     * @package Config
     */
    class Env
    {
        private $configs;

        public function __construct()
        {
            $this->configs = include('../config.php');
        }

        public function load()
        {
            foreach ($this->configs as $key => $value) {
                putenv("{$key}={$value}");
            }
        }
    }