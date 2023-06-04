FROM php:7.4-fpm

ENV TZ Asia/Tokyo

RUN apt-get update
RUN apt-get install -y git vim unzip libzip-dev libicu-dev libonig-dev
RUN apt-get install -y unzip libpq-dev
RUN apt-get install -y unzip libfreetype6-dev
RUN apt-get install -y unzip libjpeg62-turbo-dev
RUN apt-get install -y unzip libpng-dev
RUN docker-php-ext-configure gd  --with-freetype --with-jpeg
RUN docker-php-ext-install intl pdo_mysql zip bcmath
RUN docker-php-ext-install -j$(nproc) gd
RUN apt-get install -y curl gnupg
RUN apt-get install -y nodejs npm
RUN apt-get install -y gnupg
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs

COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN pecl install xdebug-3.1.6 \
&& docker-php-ext-enable xdebug

WORKDIR /app