FROM php:7.3-fpm

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
RUN apt-get update && apt-get install -y git zip unzip wget
RUN docker-php-ext-install pdo_mysql
RUN pecl install xdebug-beta && docker-php-ext-enable xdebug
COPY scripts/get_composer.sh /tmp
RUN chmod +x /tmp/get_composer.sh && /tmp/get_composer.sh
