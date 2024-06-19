# This Dockerfile effectively sets up a PHP 8.1 environment with Apache, installs necessary PHP extensions and tools (including Composer), and configures Apache's ServerName to todo-app.localhost
# It's geared towards running PHP applications that require these specific dependencies and configurations.

FROM php:8.1-apache

RUN echo "ServerName todo-app.localhost" >> /etc/apache2/apache.conf

# PHP Extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev;

# Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip calendar dom mbstring zip gd xsl
RUN pecl install apcu && docker-php-ext-enable apcu

WORKDIR /var/www/todo-app