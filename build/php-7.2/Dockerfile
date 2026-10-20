FROM composer:latest AS composer
FROM php:7.2-cli-alpine

RUN apk update && \
    apk upgrade && \
    apk add --no-cache make

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app/