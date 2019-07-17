#!/bin/bash

cd /home/hyungseok/codeship/build

php artisan clear-compiled
php artisan optimize
php artisan view:clear
php artisan cache:clear

composer update
npm install
npm run production

chown -R ubuntu:www-data ./
sudo find ./ -type d -exec chmod 755 {} +
sudo find ./ -type f -exec chmod 644 {} +
chmod -R 777 ./storage
