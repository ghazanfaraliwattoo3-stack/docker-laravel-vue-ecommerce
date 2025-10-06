# ==========================
# Stage 1: Node builder (Vite build)
# ==========================
FROM node:20-alpine AS node-builder

WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

COPY resources resources
COPY vite.config.js ./
RUN npm run build

# ==========================
# Stage 2: PHP + Laravel
# ==========================
FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash git unzip curl libzip-dev icu-dev autoconf g++ make libxml2-dev oniguruma-dev file

RUN docker-php-ext-install pdo pdo_mysql zip intl

WORKDIR /var/www/html

COPY . .

COPY --from=node-builder /var/www/html/public/build public/build

RUN php -r "copy('https://getcomposer.org/installer','composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader \
    && rm composer-setup.php

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ✅ Auto generate app key (important!)
RUN php artisan key:generate --force || true

EXPOSE 8080
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]
