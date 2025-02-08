FROM php:8.4.1-fpm-alpine

#ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . /var/www/html
