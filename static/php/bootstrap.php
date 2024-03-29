<?php
// ini_set('include_path', __DIR__);
require_once(__DIR__ . '/vendor/autoload.php');
// use Dotenv\Dotenv;

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
// $dotenv->load();
// PHP has no base64UrlEncode function, so let's define one that
// does some magic by replacing + with -, / with _ and = with ''.
// This way we can pass the string within URLs without
// any URL encoding.
function base64UrlEncode($text)
{
    return str_replace(
        ['+', '/', '='],
        ['-', '_', ''],
        base64_encode($text)
    );
}