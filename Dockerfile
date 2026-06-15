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
    libsqlite3-dev \
    && docker-php-ext-install intl pdo pdo_mysql bcmath gd opcache zip exif \
    && docker-php-ext-install pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies (skip scripts, needs .env first)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set up environment and generate APP_KEY without booting Laravel
RUN cp .env.example .env \
    && touch database/database.sqlite \
    && echo "APP_ENV=production" >> .env \
    && echo "APP_DEBUG=false" >> .env \
    && php -r '$key = "base64:" . base64_encode(random_bytes(32)); $env = file_get_contents(".env"); $env = preg_replace("/^APP_KEY=.*/m", "APP_KEY=" . $key, $env); file_put_contents(".env", $env);'

# Create all required database tables
RUN php artisan migrate --force --no-interaction 2>&1

# Run post-install scripts
RUN php artisan package:discover --ansi 2>&1

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
