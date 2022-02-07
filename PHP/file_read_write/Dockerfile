FROM alpine:3.13

RUN apk --update-cache add \
    php7 \
    php7-cli \
    php7-pecl-igbinary \
    php7-pecl-redis \
    php7-json \
    php7-openssl \
    php7-curl \
    php7-xml \
    php7-simplexml \
    php7-tokenizer \
    php7-fileinfo \
    php7-phar \
    php7-bcmath \
    php7-session \
    php7-dom \
    php7-xmlreader \
    php7-xmlwriter \
    php7-ctype \
    php7-mbstring \
    php7-sockets \
    php7-gd \
    php7-zip \
    php7-iconv \
    php7-pear \
    php7-dev \
    php7-soap \
    composer \
    autoconf \
    gcc \
    make \
    g++\
    zlib-dev \
    musl-dev \
    libzip-dev \
    libxml2-dev \
    icu-dev \
    curl \
    vim \
    bash

COPY composer.* /var/www/
COPY ./.env /var/www/.env

WORKDIR /var/www

RUN composer install -d /var/www --prefer-dist --no-scripts

COPY ./config /var/www/config
COPY ./src /var/www/src
COPY ./tests /var/www/tests
COPY ./var /var/www/var
COPY ./phpunit.xml /var/www/phpunit.xml
