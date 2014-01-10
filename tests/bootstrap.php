<?php

namespace RussellInterpreterTest;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class Bootstrap
{
    public static function init()
    {
        self::initAutoloader();
    }

    protected static function initAutoloader()
    {
        spl_autoload_register(function($class) {
            $filename = str_replace('\\', '/', $class) .'.php';
            $filename = realpath('../' . $filename);
            if ($filename) {
                include_once $filename;
            }
        });
    }
}

Bootstrap::init();