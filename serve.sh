#!/bin/bash

if [ ! -d tmp ]; then
    echo "RhymeBin: Creating tmp directory"
    mkdir tmp
fi

kill_tasks() {
    for f in gulp php-httpd livereload; do
        file="tmp/${f}.pid"
        if [ -f "$file" ]; then
            pid="$(cat "$file")"
            echo "RhymeBin: killing $f (pid=$pid) ..."
            kill -9 "$pid"
            rm "$file"
        fi
    done
}


trap kill_tasks INT

kill_tasks

echo "RhymeBin: killing previous processes, if they are still running"

echo "RhymeBin: Running gulp for the first time to compile assets ..."
gulp

echo "RhymeBin: Running gulp watch ... "
gulp watch &
echo $! > tmp/gulp.pid

echo "RhymeBin: Run LiveReload ... "
node livereload.js &
echo $! > tmp/livereload.pid

echo "RhymeBin: Running PHPs own webserver on 127.0.0.1:1337 WEBROOT=public/  ... "
php -S 127.0.0.1:1337 -t "$(dirname "${BASH_SOURCE[0]}")/public"
# echo $! > tmp/php-httpd.pid

