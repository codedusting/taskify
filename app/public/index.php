<?php

session_start();

const BASE_PATH = __DIR__."/../";

require BASE_PATH."libs/functions.php";
require basePath("libs/jwt.php");
require basePath("libs/constants.php");

spl_autoload_register(function ($class) {
    $classPath = explode("\\", $class);
    $classPath[0] = strtolower($classPath[0]);
    $loadClass = implode("\\", $classPath);
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $loadClass);
    require basePath("$class.php");
});

require basePath("libs/bootstrap.php");

use Core\Router;

$router = new Router();
require basePath("libs/routes.php");
$uri = parse_url($_SERVER["REQUEST_URI"])["path"];
$method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];

$router->routeTo($uri, $method);
