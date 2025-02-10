<?php

namespace Core;

use Exception;

class App
{
    protected static Container $container;

    public static function bind(string $key, $resolver): void
    {
        static::getContainer()->bind($key, $resolver);
    }

    public static function getContainer(): Container
    {
        return static::$container;
    }

    public static function setContainer($container): void
    {
        static::$container = $container;
    }

    /**
     * @throws Exception
     */
    public static function resolve(string $key)
    {
        return static::getContainer()->resolve($key);
    }
}