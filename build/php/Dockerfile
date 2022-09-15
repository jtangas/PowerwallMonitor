FROM php:8.0-fpm
RUN apt-get update && apt-get install -y libzip-dev && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY app/. /var/www/html/
WORKDIR /var/www/html
RUN composer install -o
RUN chown -R www-data:www-data /var/www/html
