FROM php:7.3-fpm

ENV WORKDIR /var/www/html
WORKDIR $WORKDIR

RUN apt-get update && apt-get -y install git zip unzip wget
RUN chown www-data:www-data $WORKDIR
RUN docker-php-ext-install pdo_mysql opcache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY infrastructure/scripts/get_composer.sh /tmp
COPY infrastructure/prod/php-fpm/conf.d/* /usr/local/etc/php/conf.d/
RUN chmod +x /tmp/get_composer.sh && /tmp/get_composer.sh

USER www-data
COPY --chown=www-data backend/composer.* ./
RUN composer install --no-progress --no-interaction --no-scripts --no-suggest --ansi
COPY --chown=www-data backend/ ./

# Make sure there are no dependencies with critical vulnerabilities
COPY --chown=www-data backend/security-checker.phar security-checker.phar
RUN php security-checker.phar security:check composer.lock
RUN bin/phpunit && vendor/bin/phpcs

RUN composer dump-autoload --optimize --no-dev --classmap-authoritative && \
    composer run-script --ansi post-install-cmd && \
    composer clearcache --ansi
