FROM php:8.2-fpm

ARG user
ARG uid

RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    p7zip-full \
    libpq-dev \
    libcurl4-gnutls-dev 

RUN apt clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# RUN chown -R www-data:www-data /var/www

WORKDIR /var/www

# Change the group for storage directory to root
RUN mkdir -p storage && chgrp -R root storage

# Change the owner for the vendor directory to the specified user
RUN mkdir -p vendor && chown -R $user:$user vendor

RUN mkdir -p bootstrap/cache && chown -R $user:$user bootstrap/cache


USER $user