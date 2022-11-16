FROM composer:latest as composer
FROM php:8.2-rc-cli-alpine

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        autoconf \
        g++ \
        make \
        linux-headers

RUN pecl install xdebug-3.2.0RC2 && \
    pecl clear-cache && \
    docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app/