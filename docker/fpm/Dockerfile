FROM php:7.3-fpm-alpine
COPY --from=composer:1.9.1 /usr/bin/composer /usr/bin/composer
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
WORKDIR /var/app