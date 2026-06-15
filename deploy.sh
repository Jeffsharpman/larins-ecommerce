#!/usr/bin/env bash

# 1. Generate the app encryption key if it wasn't copied over
php artisan key:generate --force

# 2. Safely discover packages and clear application caches
php artisan package:discover --ansi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Start the Nginx web server and PHP processing engines together
nginx -g "daemon off;" & php-fpm