# ==========================
# Stage 1: Node builder (Vite build)
# ==========================
FROM node:20-alpine AS node-builder

WORKDIR /var/www/html

# Copy package.json and package-lock.json for npm install
COPY package*.json ./

# Install Node dependencies
RUN npm install

# Copy resources folder (JS/CSS source)
COPY resources resources
COPY vite.config.js ./

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

WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Copy built Vite assets from node-builder
COPY --from=node-builder /var/www/html/public/build public/build

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer','composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader \
    && rm composer-setup.php

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
