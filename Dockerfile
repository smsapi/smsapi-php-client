FROM composer:latest as composer
FROM php:7.0-cli-alpine

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        autoconf \
        g++ \
        make

RUN pecl install xdebug-2.7.2 && \
    pecl clear-cache && \
    docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app/