FROM php:8.2-apache

# csomagok telepítése
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

# composer 
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN a2enmod rewrite

#  munkakönyvtárak
WORKDIR /var/www/html
COPY . /var/www/html
COPY .env /var/www/html/.env

RUN composer install --no-dev --optimize-autoloader && \
    composer require vlucas/phpdotenv

# jogosultságok 
RUN chown -R www-data:www-data /var/www/html

# apache indítása
CMD ["apache2-foreground"]
