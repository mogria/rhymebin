#!/usr/bin/env bash

SOURCE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

cd "$SOURCE_DIR"
cat <<'INTRO'
 ____  _     _   _           _   _ ____  _
|  _ \| |__ (_) (_)_ __ ___ (_)_(_) __ )(_)_ __
| |_) | '_ \| | | | '_ ` _ \ / _ \|  _ \| | '_ \
|  _ <| | | | |_| | | | | | |  __/| |_) | | | | |
|_| \_\_| |_|\__, |_| |_| |_|\___||____/|_|_| |_|
             |___/ Installer, by mogria for güssl

INTRO
 
check_if_program_available() {
    echo -n "RhymeBin: checking if $1 is available "
    "$1" --version &> /dev/null
    if [ "$?" -eq 0 ];  then
        echo "[OK]";
    else
        echo "[FAIL]";
        exit 1
    fi
}

check_if_program_available "php"
check_if_program_available "composer"
check_if_program_available "node"
check_if_program_available "npm"


echo "RhymeBin: Running composer install to grab lumen and other PHP dependencies"
composer install

echo "RhymeBin: Running npm install to grab bower & gulp"
npm install

# temporarily add bower in submodule to PATH, in case it isn't found
export PATH="$PATH:./node_modules/bower/bin"
echo "RhymeBin: Running bower install to grab client side JavaScript libraries"
bower install

if [ ! -f '.env' ]; then
    echo "RhymeBin: Copying default environment configuration (database connection, memcached configuration, etc.)"
    cp .env.example .env
fi

echo "RhymeBin: Seeding the database with php artisan db:seed"
php artisan db:seed

