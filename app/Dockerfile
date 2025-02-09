FROM php:8.4.3-fpm-alpine

RUN apk add --no-cache postgresql-dev

RUN docker-php-ext-install pdo pgsql pdo_pgsql

WORKDIR /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer

COPY ./composer.* ./

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

COPY . .

RUN composer dump-autoload --optimize

EXPOSE 9000

CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]