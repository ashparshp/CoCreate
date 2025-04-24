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
    nodejs \
    npm \
    sqlite3 \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app files
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install \
    && npm run build \
    && php artisan config:cache

# Expose port Laravel will run on
EXPOSE 8000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000