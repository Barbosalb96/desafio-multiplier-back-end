FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y \
    curl \
    git \
    unzip \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    zlib1g-dev \
    libpq-dev \
    libzip-dev \
    telnet

RUN docker-php-ext-install \
    zip \
    gd \
    pdo \
    pdo_mysql \

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

CMD ["php-fpm"]
