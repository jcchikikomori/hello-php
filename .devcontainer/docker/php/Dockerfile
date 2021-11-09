# ARG PHP_VERSION=8.0
FROM php:8.0-fpm

ARG DEBIAN_FRONTEND=noninteractive

# Use the default development configuration
RUN ln -s "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y \
    unzip wget && rm -rf /var/lib/apt/lists/*

# install PDO
# RUN apt-get install -y libpq5 \
#     && docker-php-ext-install -j$(nproc) pdo pdo_mysql pdo_pgsql \
#     && rm -rf /var/lib/apt/lists/*
# Currently unstable for postgresql
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# install bcmath
RUN docker-php-ext-install -j$(nproc) bcmath

# install gd
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && rm -rf /var/lib/apt/lists/*

# install mysqli
RUN docker-php-ext-install -j$(nproc) mysqli

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ARG XDEBUG_REMOTE_ENABLE=1
ARG XDEBUG_REMOTE_AUTOSTART=1
ARG XDEBUG_REMOTE_CONNECT_BACK=1
ARG XDEBUG_REMOTE_HOST=localhost
ARG XDEBUG_REMOTE_PORT=9001
ARG XDEBUG_REMOTE_LOG

# Install xdebug 
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=${XDEBUG_REMOTE_ENABLE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=${XDEBUG_REMOTE_AUTOSTART}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=${XDEBUG_REMOTE_CONNECT_BACK}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=${XDEBUG_REMOTE_HOST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=${XDEBUG_REMOTE_PORT}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_log=${XDEBUG_REMOTE_LOG}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_output_dir=/tmp/snapshots" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_nesting_level=9999" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_enable_trigger=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# TODO: find a way to detect a codespace deployment
# The CODESPACES environment variable is not set in additional containers
RUN [ -n "${CODESPACES}" -a "${CODESPACES}" = 1 ] \
    && sed -i "s/xdebug.remote_connect_back=${XDEBUG_REMOTE_CONNECT_BACK}/xdebug.remote_connect_back=0/" ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini \
    || echo "Not running in a codespace"
