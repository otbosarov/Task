#!/bin/bash
php artisan optimize

php artisan config:cache

php artisan config:clear

php artisan cache:clear

#sudo chown -R $USER:$USER storage

#php artisan cache:load

#sudo chown -R www-data:www-data storage/
