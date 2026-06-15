# Use the official optimized PHP 8.3 FPM image
FROM php:8.4-fpm-alpine

# Install system dependencies and PHP extensions for Laravel & MySQL
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip git \
    && docker-php-ext-install pdo_mysql bcmath gd

# Get the latest stable Composer package manager
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory inside the container
WORKDIR /var/www

# Copy your local project code into the container
COPY . .

# Install dependencies without running scripts (needs .env first)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set up environment and generate app key
RUN cp .env.example .env && php artisan key:generate

# Now run post-install scripts now that the app is bootable
RUN php artisan package:discover --ansi

# Set permissions so web servers can read your cache/storage
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 80 for Render web traffic routing
EXPOSE 80

# Start Nginx and PHP via a startup script
CMD ["sh", "./deploy.sh"]
