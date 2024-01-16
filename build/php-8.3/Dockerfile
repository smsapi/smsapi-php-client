FROM composer:latest as composer
FROM php:8.3-cli-alpine

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        autoconf \
        g++ \
        make \
        linux-headers

RUN pecl install xdebug-3.3.1 && \
    pecl clear-cache && \
    docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app/