FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
 git \
 curl \
 zip \
 unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/app

USER root
