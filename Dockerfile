FROM php:8.2-alpine

RUN docker-php-ext-install pdo_mysql

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer