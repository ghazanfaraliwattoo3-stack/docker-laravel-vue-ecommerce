# ==========================
# Stage 1: Node builder (Vite build)
# ==========================
FROM node:20-alpine AS node-builder

WORKDIR /var/www/html

# Copy package files for npm install
COPY package*.json ./

# Install Node dependencies
RUN npm install

# Copy JS/CSS source & Vite config
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

# Set working directory
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

# Set permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose Render HTTP port
EXPOSE 8080

# Run PHP built-in server (Render expects public HTTP port)
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]
