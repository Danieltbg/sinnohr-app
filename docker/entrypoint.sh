#!/bin/sh
set -e

cd /var/www/html

mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

if [ -f .env ]; then
    php artisan config:cache --no-ansi || true
    php artisan route:cache --no-ansi || true
    php artisan view:cache --no-ansi || true
    php artisan filament:cache-components --no-ansi || true
fi

exec "$@"
