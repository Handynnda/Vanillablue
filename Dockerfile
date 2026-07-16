FROM php:8.3-apache

WORKDIR /var/www/html

COPY . .

# Install library yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        intl \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache Rewrite
RUN a2enmod rewrite

# Set DocumentRoot ke folder public Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Storage link
RUN php artisan storage:link || true

# Permission - PENTING: www-data adalah user Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]