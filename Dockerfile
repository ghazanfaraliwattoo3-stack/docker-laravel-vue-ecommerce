# 1️⃣ Base image
FROM php:8.2-fpm-alpine

# 2️⃣ Working directory
WORKDIR /var/www

# 3️⃣ System dependencies aur PHP extensions install karo
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    npm \
    nodejs \
    libzip-dev \
    zip \
    oniguruma-dev \
    icu-dev \
    autoconf \
    g++ \
    make \
    libxml2-dev \
    file \
    bash \
    && docker-php-ext-install pdo pdo_mysql zip intl dom tokenizer session

# 4️⃣ Composer install karo (agar Alpine pe latest composer nahi hai)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 5️⃣ Project files copy karo
COPY . .

# 6️⃣ Composer dependencies install karo
RUN composer install --optimize-autoloader --no-dev

# 7️⃣ Node modules install & Vite build
RUN npm install
RUN npm run build

# 8️⃣ Laravel caches clear & storage link
RUN php artisan view:clear
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan storage:link || true

# 9️⃣ Ports
EXPOSE 8000

# 🔟 Default command
CMD php artisan serve --host=0.0.0.0 --port=8000
