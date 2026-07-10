FROM php:8.2-apache

# Install library yang dibutuhkan CodeIgniter
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql zip intl

# Enable Apache Rewrite
RUN a2enmod rewrite

# Copy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install dependency
RUN composer install --no-dev --optimize-autoloader

# Gunakan apache.conf
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 writable

EXPOSE 80