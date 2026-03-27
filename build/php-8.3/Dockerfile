FROM composer:latest as composer
FROM php:8.3-cli-alpine

RUN apk update && \
    apk upgrade && \
    apk add --no-cache make

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app/