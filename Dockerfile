FROM php:8.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    && docker-php-ext-install intl pdo pdo_mysql bcmath gd zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Nginx config
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD ["./start.sh"]

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

# Simple and reliable for deployment platforms
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]