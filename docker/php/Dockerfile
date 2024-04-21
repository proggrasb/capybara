FROM php:8.2-fpm-alpine

ARG PHP_MAX_EXECUTION_TIME
ARG WORKDIR_SITE

RUN apk add --update --no-cache curl git build-base zlib-dev autoconf bash shadow libpq-dev linux-headers \
  && docker-php-ext-install pdo_pgsql

RUN cp "/usr/local/etc/php/php.ini-development" "/usr/local/etc/php/php.ini"


RUN sed -i \
    -e "s/;date.timezone =.*/date.timezone = UTC/" /usr/local/etc/php/php.ini \
    -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /usr/local/etc/php/php.ini \
    -e "s/max_execution_time = .*/max_execution_time = ${PHP_MAX_EXECUTION_TIME}/" /usr/local/etc/php/php.ini \
    -e "s/pid =.*/pid = \/var\/run\/php-fpm.pid/" /usr/local/etc/php-fpm.conf \
    -e "s/error_log =.*/error_log = \/proc\/self\/fd\/2/" /usr/local/etc/php-fpm.conf \
    -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /usr/local/etc/php-fpm.conf \
    -e "s/;catch_workers_output = .*/catch_workers_output = yes/" /usr/local/etc/php-fpm.d/www.conf \
    && mkdir -p /run/php

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#USER www-data

COPY . $WORKDIR_SITE
WORKDIR $WORKDIR_SITE

CMD php-fpm

EXPOSE 9000
