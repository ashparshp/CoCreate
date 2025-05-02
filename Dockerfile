# Use official PHP image with necessary extensions
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application source
COPY . .

# Ensure SQLite DB exists
RUN mkdir -p database && touch database/database.sqlite

# Install PHP and Node dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev \
    && npm install \
    && npm run build \
    && php artisan config:cache

# Expose port
EXPOSE 8000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
