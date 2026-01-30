FROM php:8.3-cli-alpine

RUN apk add --no-cache git unzip libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install