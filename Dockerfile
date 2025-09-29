# Base PHP 8.1
FROM php:8.1-fpm

# Instalar dependencias y extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev zip gnupg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Node.js 16.12
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir directorio de trabajo
WORKDIR /var/www/html

# Copiar dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copiar dependencias de Node
COPY package.json package-lock.json* yarn.lock* ./
RUN npm install

# Copiar código del proyecto
COPY . .

# Optimizar autoload de Laravel
RUN composer dump-autoload --optimize

EXPOSE 9000
CMD ["php-fpm"]

