<?php

declare(strict_types=1);

/**
 * Router for PHP's built-in server (Windows-safe).
 *
 * Prefer `public/server.php` via `php artisan serve` (see WindowsSafeServeCommand).
 * Manual serve from public/: php -S 127.0.0.1:8001 server.php
 */
$publicPath = getcwd();

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';
