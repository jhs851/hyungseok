FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd \
       --with-gd \
       --with-freetype-dir=/usr/include/ \
       --with-png-dir=/usr/include/ \
       --with-jpeg-dir=/usr/include/ && \
     NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
     docker-php-ext-install -j${NPROC} gd

RUN docker-php-source extract && \
  pecl install redis && \
  docker-php-ext-enable redis && \
  docker-php-ext-install mysqli && \
  docker-php-ext-install pdo_mysql && \
  docker-php-source delete

RUN rm -rf /var/cache/apk/*

RUN sed -i "s/;date.timezone =/date.timezone = Asia\/Seoul/g" "$PHP_INI_DIR/php.ini-production"

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
