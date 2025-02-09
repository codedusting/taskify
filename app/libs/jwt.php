<?php

if (!function_exists("generateJWT")) {
    function generateJWT($payload, string $secret): string
    {
        $header = json_decode(["typ" => "JWT", "alg" => "HS256"]);
        $payload = json_decode($payload);

        $base64UrlHeader = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($header));
        $base64UrlPayload = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($payload));

        $signature = hash_hmac("sha256", $base64UrlHeader.".".$base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));

        return $base64UrlHeader.".".$base64UrlPayload.".".$base64UrlSignature;
    }
}

if (!function_exists("verifyJWT")) {
    function verifyJWT(string $jwt, string $secret): bool
    {
        $parts = explode(".", $jwt);
        $header = json_decode(base64_decode($parts[0]), true);
        $signature = json_decode(base64_decode($parts[2]), true);

        if ($header["alg"] !== "HS256") {
            return false;
        }
        $expectedSignature = hash_hmac("sha256", $parts[0].".".$parts[1], $secret, true);
        return hash_equals($signature, $expectedSignature);
    }
}

if (!function_exists("decodeJWT")) {
    function decodeJWT(string $jwt, string $secret)
    {
        $parts = explode(".", $jwt);
        return json_decode(base64_decode($parts[1]), true);
    }
}