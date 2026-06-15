#!/usr/bin/env bash

# Optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the web server engine
nginx -g "daemon off;" & php-fpm
