FROM php:8.4.3-fpm-alpine

RUN apk add --no-cache postgresql-dev

RUN docker-php-ext-install pdo pgsql pdo_pgsql

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer

COPY ./app/composer.* ./

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

COPY ./app .

RUN composer dump-autoload --optimize