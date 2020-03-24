<?php

namespace Mouyong\Foundation;

use Monolog\Logger;
use Monolog\Handler\NullHandler;
use Monolog\Handler\ErrorLogHandler;

class Log
{
    protected static $logger;

    public static function setLogger($logger)
    {
        Log::$logger = $logger;
    }

    public static function getLogger()
    {
        return Log::$logger ?: Log::$logger = Log::createDefaultLogger();
    }

    public static function hasLogger()
    {
        return Log::$logger ? true : false;
    }

    public static function createDefaultLogger()
    {
        $log = new Logger('foundation');

        if (defined('PHPUNIT_RUNNING') || php_sapi_name() === 'cli') {
            $log->pushHandler(new NullHandler());
        } else {
            $log->pushHandler(new ErrorLogHandler());
        }

        return $log;
    }

    public static function __callStatic($method, $args)
    {
        return forward_static_call([Log::getLogger(), $method], $args);
    }

    public function __call($method, $args)
    {
        return call_user_func_array([Log::getLogger(), $method], $args);
    }
}