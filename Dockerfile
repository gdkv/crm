FROM php:8.0-fpm

RUN apt-get update && apt-get install -y

RUN apt-get install -y --no-install-recommends \
        coreutils \
        freetype* \
        # libjpeg-progs \
        # libpng-dev \
        postgresql \
        autoconf \
        gcc \
        make \
        g++ \
        supervisor \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libpq-dev \
        nano

# RUN docker-php-ext-configure gd --with-freetype --with-jpeg=/usr/include

RUN docker-php-ext-install \
        zip \
        intl \
        pdo_pgsql \
        # gd \
        opcache

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.fast_shutdown=1'; \
} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Install Composer !
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Set the default directory inside the container
WORKDIR /var/www/app
COPY ./ /var/www/app/
RUN composer install
