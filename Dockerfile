# Use the official optimized PHP 8.4 FPM image
FROM php:8.4-fpm-alpine

# Install system dependencies, critical core PHP extensions, AND Linux building tools
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip git oniguruma-dev \
    build-base autoconf automake libtool make g++ gcc \
    && docker-php-ext-install pdo_mysql bcmath gd mbstring xml

# Get the latest stable Composer package manager
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# CRITICAL FIX 1: Allow Composer to use unlimited system memory during the build
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_ALLOW_SUPERUSER=1

# Set working directory inside the container
WORKDIR /var/www

# Copy your local project code into the container
COPY . .

# CRITICAL FIX 2: Completely bypass scripts, ignore platform mismatches, and run raw install
RUN composer install --no-dev --no-scripts --no-interaction --optimize-autoloader --ignore-platform-reqs

# Copy the example environment file
RUN cp .env.example .env

# Set permissions so web servers can write cache/logs
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 80 for Render web traffic routing
EXPOSE 80

# Run all artisan booting, key generation, and servers at RUNTIME instead of BUILD time
CMD ["sh", "./deploy.sh"]