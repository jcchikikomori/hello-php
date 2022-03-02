# [Choice] PHP version (use -bullseye variants on local arm64/Apple Silicon): 8, 8.1, 8.0, 7, 7.4, 7.3, 8-bullseye, 8.1-bullseye, 8.0-bullseye, 7-bullseye, 7.4-bullseye, 7.3-bullseye, 8-buster, 8.1-buster, 8.0-buster, 7-buster, 7.4-buster
ARG VARIANT=8-bullseye
FROM mcr.microsoft.com/vscode/devcontainers/php:0-${VARIANT}

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

# [Choice] Node.js version: none, lts/*, 16, 14, 12, 10
ARG NODE_VERSION="none"
RUN if [ "${NODE_VERSION}" != "none" ]; then su vscode -c "umask 0002 && . /usr/local/share/nvm/nvm.sh && nvm install ${NODE_VERSION} 2>&1"; fi

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

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

# Note: xDebug implementation was old
# xDebug Source: https://xdebug.org/docs/upgrade_guide
ARG XDEBUG_MODE=debug
ARG XDEBUG_START_WITH_REQUEST=yes
ARG XDEBUG_REMOTE_AUTOSTART=1
ARG XDEBUG_REMOTE_CONNECT_BACK=true
ARG XDEBUG_REMOTE_HOST=localhost
ARG XDEBUG_REMOTE_PORT=9001
ARG XDEBUG_REMOTE_LOG

# Install xdebug
RUN pecl install xdebug || true
RUN docker-php-ext-enable xdebug

RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=${XDEBUG_REMOTE_CONNECT_BACK}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=${XDEBUG_REMOTE_HOST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=${XDEBUG_REMOTE_PORT}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=${XDEBUG_REMOTE_LOG}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.output_dir=/tmp/snapshots" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_nesting_level=9999" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

