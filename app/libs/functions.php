<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function dd($value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

#[NoReturn] function abort($status = 404): void
{
    http_response_code($status);
    require basePath("http/controllers/$status.php");
    die();
}

function basePath(string $path): string
{
    return BASE_PATH.$path;
}

function view(string $path, array $attributes = []): void
{
    extract($attributes);
    require basePath("http/views/".$path);
}

#[NoReturn] function redirect(string $path): void
{
    header("location: $path");
    exit();
}