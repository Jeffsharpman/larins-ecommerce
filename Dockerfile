# Use the official optimized PHP 8.4 FPM image
FROM php:8.4-fpm-alpine

# Install system dependencies AND critical core PHP extensions for Laravel 11/12
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip git oniguruma-dev \
    && docker-php-ext-install pdo_mysql bcmath gd mbstring xml

# Get the latest stable Composer package manager
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Allow Composer plugins to execute safely as root during build
ENV COMPOSER_ALLOW_SUPERUSER=1

# Set working directory inside the container
WORKDIR /var/www

# Copy your local project code into the container
COPY . .

# Install dependencies safely without running un-booted background scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# Copy the example environment file
RUN cp .env.example .env

# Set permissions so web servers can write cache/logs
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 80 for Render web traffic routing
EXPOSE 80

# Run all artisan booting, key generation, and servers at RUNTIME instead of BUILD time
CMD ["sh", "./deploy.sh"]