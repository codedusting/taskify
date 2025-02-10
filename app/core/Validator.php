<?php

namespace Core;

class Validator
{
    public static function urlIs(string $url): bool
    {
        return $_SERVER["REQUEST_URI"] === $url;
    }

    public static function string(string $value, int $min = 1, int $max = INF): bool
    {
        $value = trim($value);
        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function array(array $value): bool
    {
        return !empty($value); // isset($value) && is_array($value) &&
    }
}