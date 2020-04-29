<?php

namespace ParseFileSpl\Facade;

use ParseFileSpl\Container\FileContainer;

/**
 * Class ParseFacade
 * @package ParseFileSpl\Facade
 */
class ParseFacade
{
    public static $container;

    public function __construct()
    {
        self::$container = new FileContainer();

        self::$container->bind('csv', new CsvFacade());
        self::$container->bind('text', new TextFacade());
    }

    public static function csv() {
        return self::$container->make('csv');
    }

    public static function text() {
        return self::$container->make('text');
    }
}

