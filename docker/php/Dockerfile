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
    pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# COPY . /var/www/html

# RUN chown -R www-data:www-data /var/www/html/storage
# RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

CMD ["php-fpm"]
