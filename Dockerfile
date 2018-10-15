FROM composer:1.6.5 as composer

FROM php:7.1.22-alpine3.8

ENV USER docker

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 $USER && \
    adduser -D -u 1000 -G $USER $USER

USER $USER

COPY --chown=docker:docker . /app