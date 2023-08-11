FROM php:8.1-fpm-alpine

# zsh
RUN apk add zsh

# git
RUN apk add git

# pdo
RUN docker-php-ext-install pdo

# psql
RUN apk add postgresql-dev
RUN docker-php-ext-install pdo_pgsql

# zip
RUN apk add libzip-dev zip unzip
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

# gd
RUN apk add libpng libpng-dev freetype-dev
RUN docker-php-ext-configure gd --with-freetype
RUN docker-php-ext-install gd

# composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /app
