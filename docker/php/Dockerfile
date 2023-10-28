FROM php:8.2.12-fpm

# Install PDO extension
RUN docker-php-ext-install pdo pdo_mysql

# Install Xdebug extension
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install packages
RUN apt-get update \
    && apt-get install -y \
    unzip \
    zip