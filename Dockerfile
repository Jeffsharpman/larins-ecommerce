FROM php:8.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install intl pdo pdo_mysql pdo_sqlite bcmath gd opcache zip exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies (skip scripts, needs .env first)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set up environment and generate app key
RUN cp .env.example .env && touch database/database.sqlite && php artisan key:generate

# Run post-install scripts
RUN php artisan package:discover --ansi

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
