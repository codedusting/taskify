<?php

function dd($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
//    die();
}

dd("functions.php");

function basePath(string $path): string
{
    return BASE_PATH . $path;
}