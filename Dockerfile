# ==========================
# Stage 1: Node builder (for Vite)
# ==========================
FROM node:20-alpine AS node-builder

# Set working directory
WORKDIR /var/www/html

# Copy package files
COPY package.json package-lock.json ./

# Install Node dependencies
RUN npm install

# Copy rest of the frontend files
COPY resources resources

# Build Vite assets
RUN npm run build

# ==========================
# Stage 2: PHP + Laravel
# ==========================
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    libzip-dev \
    icu-dev \
    autoconf \
    g++ \
    make \
    libxml2-dev \
    oniguruma-dev \
    file \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip intl

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Copy built frontend assets from node-builder
COPY --from=node-builder /var/www/html/dist public/dist

# Install PHP dependencies
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader \
    && rm composer-setup.php

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Run PHP-FPM
CMD ["php-fpm"]
