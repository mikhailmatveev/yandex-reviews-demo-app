FROM php:8.3-fpm-bullseye

RUN apt-get update \
    && apt-get -y install unzip git gzip

# Install php extensions
RUN apt-get -y install libonig-dev zlib1g-dev libzip-dev libxml2-dev libpng-dev libpq-dev \
    && docker-php-ext-install iconv mbstring pdo pdo_mysql pdo_pgsql pgsql opcache zip soap bcmath gd pcntl

# Install node
SHELL ["/bin/bash", "--login", "-c"]
ENV NVM_DIR /opt/nvm
RUN mkdir $NVM_DIR \
    && curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash \
    && source $NVM_DIR/nvm.sh && nvm install 16 \
    && source $NVM_DIR/nvm.sh && nvm use 16 && nvm alias default 16 \
    && npm install -g pm2 \
    && ln -s $(which node) /usr/bin/node \
    && ln -s $(which npm) /usr/bin/npm \
    && ln -s $(which pm2) /usr/bin/pm2 \
    && ln -s $(which pm2-runtime) /usr/bin/pm2-runtime

# Install composer
COPY --from=composer:2.5 /usr/bin/composer /usr/local/bin/composer
