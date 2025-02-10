<?php

namespace core;

use Exception;
use Random\RandomException;

class NanoIdGenerator
{
    protected const string PUBLIC_ID_ALPHABET = "0123456789abcdefghijklmnopqrstuvwxyz";
    protected const int PUBLIC_ID_LENGTH = 12;
    protected const int MAX_RETRY = 1000;

    /**
     * @throws Exception
     */
    public static function generateUniqueId(callable $isUniqueCallback): string
    {
        for ($attempt = 0; $attempt < self::MAX_RETRY; $attempt++) {
            $id = self::generateNanoId();
            if ($isUniqueCallback($id)) {
                return $id;
            }
        }
        throw new Exception("Failed to generate a unique public ID after ".self::MAX_RETRY." attempts");
    }

    /**
     * @throws RandomException
     */
    public static function generateNanoId(
        string $alphabet = self::PUBLIC_ID_ALPHABET,
        int $size = self::PUBLIC_ID_LENGTH
    ): string {
        $id = "";
        $alphabetLength = strlen($alphabet);
        for ($i = 0; $i < $size; $i++) {
            $randomIndex = random_int(0, $alphabetLength - 1);
            $id .= $alphabet[$randomIndex];
        }
        return $id;
    }
}