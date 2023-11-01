#!/bin/bash
cd /var/www
php-fpm

composer install
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache


php artisan cache:clear
php artisan route:clear
php artisan optimize:clear
php artisan migrate
php artisan db:seed