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
    nodejs \
    npm \
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
    && php -r '$env = file_get_contents(".env"); \
        $replacements = [ \
            "APP_ENV=local" => "APP_ENV=production", \
            "APP_DEBUG=true" => "APP_DEBUG=false", \
            "SESSION_DRIVER=database" => "SESSION_DRIVER=file", \
            "CACHE_STORE=database" => "CACHE_STORE=array", \
            "QUEUE_CONNECTION=database" => "QUEUE_CONNECTION=sync", \
        ]; \
        $env = str_replace(array_keys($replacements), array_values($replacements), $env); \
        $key = "base64:" . base64_encode(random_bytes(32)); \
        $env = preg_replace("/^APP_KEY=.*/m", "APP_KEY=" . $key, $env); \
        file_put_contents(".env", $env);'

# Create the settings table manually (Spatie settings queries it during app boot, before migrations run)
RUN php -r '$db = new SQLite3("database/database.sqlite"); $db->exec("CREATE TABLE IF NOT EXISTS settings (id INTEGER PRIMARY KEY AUTOINCREMENT, \"group\" TEXT NOT NULL, name TEXT NOT NULL, locked INTEGER NOT NULL DEFAULT 0, payload TEXT NOT NULL, created_at TEXT, updated_at TEXT, UNIQUE(\"group\", name))");' \
    && php artisan migrate --force --no-interaction 2>&1

# Run post-install scripts
RUN php artisan package:discover --ansi 2>&1

# Seed roles and admin users
RUN php artisan db:seed --class=ProductionSeeder --force --no-interaction 2>&1

# Build frontend assets
RUN npm install && npm run build

# Set permissions for www-data on all writable paths including the SQLite database
RUN chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

EXPOSE 8080

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
