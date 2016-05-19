#!/bin/bash
echo "RhymeBin: Running gulp for the first time to compile assets ..."
gulp

echo "RhymeBin: Running gulp watch ... "
gulp watch &

echo "RhymeBin: Running PHPs own webserver on 127.0.0.1:1337 WEBROOT=public/  ... "
php -S 127.0.0.1:1337 -t "$(dirname "${BASH_SOURCE[0]}")/public"
