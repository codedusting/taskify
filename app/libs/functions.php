<?php

use Core\Response;
use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function dd($value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

#[NoReturn] function abort($status = Response::NOT_FOUND): void
{
    http_response_code($status);
    require basePath("internal/controllers/$status.php");
    die();
}

function basePath(string $path): string
{
    return BASE_PATH.$path;
}

function view(string $path, array $attributes = []): void
{
    extract($attributes);
    require basePath("internal/views/".$path);
}

#[NoReturn] function redirect(string $path): void
{
    header("location: $path");
    exit();
}

function unsetPartialSessions(): void
{
    unset($_SESSION["_flash"]);
    unset($_SESSION["_persist"]);
}