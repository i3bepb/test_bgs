FROM php:7.4-cli-alpine

ARG MY_USER
ARG MY_USER_ID
ARG PHP_FPM_ROOTDIR

RUN addgroup -g ${MY_USER_ID} -S ${MY_USER} && adduser -S -u ${MY_USER_ID} ${MY_USER} -G ${MY_USER} \
    && mkdir -p ${PHP_FPM_ROOTDIR} && chown -R ${MY_USER}:root ${PHP_FPM_ROOTDIR} \
    && apk update && apk --no-cache add postgresql-dev libzip-dev oniguruma-dev \
    && docker-php-ext-install pgsql pdo_pgsql mbstring zip exif pcntl bcmath sockets intl

WORKDIR /var/www/html