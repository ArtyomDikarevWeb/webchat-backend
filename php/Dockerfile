FROM php:8.5-fpm

RUN apt-get update && apt-get install curl \
  && curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip intl

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY ./php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY ./src /var/www/webchat

ARG PGID=${PGID:-1000}
ARG PUID=${PUID:-1000}

RUN groupadd -g ${PGID} www-group \
    && useradd -u ${PUID} -g www-group www-user

RUN chown -R www-user:www-group /var/www

WORKDIR /var/www/webchat

USER www-user
