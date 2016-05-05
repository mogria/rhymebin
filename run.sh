#!/bin/bash

SOURCE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

cd "$SOURCE_DIR"

echo "RhymeBin: Running composer install to grab lumen and other PHP dependencies"
composer install

echo "RhymeBin: Running npm install to grab bower & gulp"
npm install

echo "RhymeBin: Running bower install to grab client side JavaScript libraries"
bower install

if [ ! -f '.env' ]; then
    echo "RhymeBin: Copying default environment configuration (database connection, memcached configuration, etc.)"
    cp .env.example .env
fi

echo "RhymeBin: Running gulp for the first time to compile assets ..."
gulp

echo "RhymeBin: Seeding the database with php artisan db:seed"
php artisan db:seed

echo "RhymeBin: Running gulp watch ... "
gulp watch &

echo "RhymeBin: Running PHPs own webserver on 127.0.0.1:1337 WEBROOT=public/  ... "
php -S 127.0.0.1:1337 -t "$(dirname "${BASH_SOURCE[0]}")/public"
