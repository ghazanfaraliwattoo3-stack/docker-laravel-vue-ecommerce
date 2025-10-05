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
    composer

# 4️⃣ Project files copy karo
COPY . .

# 5️⃣ Node modules install & Vite build
RUN npm install
RUN npm run build

# 6️⃣ Laravel caches clear
RUN php artisan view:clear
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan storage:link || true

# 7️⃣ Ports
EXPOSE 8000

# 8️⃣ Default command
CMD php artisan serve --host=0.0.0.0 --port=8000
