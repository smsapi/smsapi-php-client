FROM composer:latest AS composer
FROM php:8.5-cli-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app/