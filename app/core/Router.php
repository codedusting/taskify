<?php

namespace Core;

use JetBrains\PhpStorm\NoReturn;

class Router
{
    private $routes = [];

    public function __construct()
    {
        dd("Router.php");
    }

    #[NoReturn] public function routeTo(string $uri, string $method): void {
        dd("uri: " . $uri . " | method: ". $method);
    }
}