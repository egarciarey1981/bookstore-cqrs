FROM php:8.2-alpine

# Instalar dependencias necesarias
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    linux-headers

# Instalar extensiones PHP requeridas
RUN docker-php-ext-install pdo_mysql

# Instala XDdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
