# 1️⃣ Base image
FROM php:8.2-fpm-alpine

# 2️⃣ Working directory
WORKDIR /var/www

# 3️⃣ System dependencies install karo
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    npm \
    nodejs \
    libzip-dev \
    zip \
    composer \
    oniguruma-dev \
    icu-dev \
    bash \
    autoconf \
    g++ \
    make

# 4️⃣ PHP extensions install karo (Laravel ke liye)
RUN docker-php-ext-install pdo pdo_mysql zip intl

# 5️⃣ Project files copy karo
COPY . .

# 6️⃣ Composer dependencies install karo
RUN composer install --optimize-autoloader --no-dev

# 7️⃣ Node modules install & Vite build
RUN npm install
RUN npm run build

# 8️⃣ Laravel caches clear
RUN php artisan view:clear
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan storage:link || true

# 9️⃣ Ports
EXPOSE 8000

# 🔟 Default command
CMD php artisan serve --host=0.0.0.0 --port=8000
