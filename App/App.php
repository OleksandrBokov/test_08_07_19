<?php

/**
 * Class App
 */
class App
{
    public static $router;

    public static $db;

    public static $kernel;

    /**
     * Init function
     */
    public static function init()
    {
        spl_autoload_register(['static','loadClass']);
        static::bootstrap();
        set_exception_handler(['App','handleException']);
    }

    /**
     * bootstrap application
     */
    public static function bootstrap()
    {
        static::$router = new App\Router();
        static::$kernel = new App\Kernel();
        static::$db = new App\Db();
    }

    /**
     * @param $className
     */
    public static function loadClass ($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        require_once ROOTPATH.DIRECTORY_SEPARATOR.$className.'.php';
    }

    /**
     * @param Throwable $e
     */
    public function handleException (Throwable $e)
    {
        if ($e instanceof \App\Exceptions\InvalidRouteException) {
            echo static::$kernel->launchAction('Error', 'error404', [$e]);
        } else {
            echo static::$kernel->launchAction('Error', 'error500', [$e]);
        }
    }
}