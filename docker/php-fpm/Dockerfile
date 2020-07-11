FROM php:7.4-fpm-alpine

ARG MY_USER
ARG MY_USER_ID

RUN addgroup -g ${MY_USER_ID} -S ${MY_USER} && adduser -S -u ${MY_USER_ID} ${MY_USER} -G ${MY_USER} \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&  php composer-setup.php \
    && php -r "unlink('composer-setup.php');" && mv ./composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer && apk update && apk --no-cache add postgresql-dev libzip-dev oniguruma-dev git \
    && docker-php-ext-install pgsql pdo_pgsql mbstring zip exif pcntl bcmath sockets intl

WORKDIR /var/www/html