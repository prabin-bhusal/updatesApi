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

# COPY ./entrypoint.sh /var/www/
# RUN chmod +x /var/www/entrypoint.sh
# ENTRYPOINT ["/var/www/entrypoint.sh"]



USER $user