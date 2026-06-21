<?php

declare(strict_types=1);

/**
 * Router for PHP built-in server (Windows-safe, no stdout logging).
 *
 * @see \App\Console\WindowsSafeServeCommand
 */
$publicPath = getcwd();

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';
