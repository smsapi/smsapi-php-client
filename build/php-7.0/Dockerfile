FROM composer:2.2 as composer
FROM php:7.0-cli-alpine

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        autoconf \
        g++ \
        make

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app/