FROM php:8.2-apache

# Installer les dépendances nécessaires pour PostgreSQL
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git libpq-dev

# Installer et activer les extensions PHP nécessaires
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 9000

CMD php artisan serve --host=0.0.0.0 --port=8000