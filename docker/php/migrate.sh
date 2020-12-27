#!/bin/bash
cd /app/backend
chmod 0777 ./storage/logs/laravel.log
php artisan migrate
php artisan db:seed
php-fpm
