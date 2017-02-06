#!/usr/bin/env bash

cat <<'INTRO'
 ____  _     _   _           _   _ ____  _
|  _ \| |__ (_) (_)_ __ ___ (_)_(_) __ )(_)_ __
| |_) | '_ \| | | | '_ ` _ \ / _ \|  _ \| | '_ \
|  _ <| | | | |_| | | | | | |  __/| |_) | | | | |
|_| \_\_| |_|\__, |_| |_| |_|\___||____/|_|_| |_|
             |___/
INTRO

if [ ! -d tmp ]; then
    echo "RhymeBin: Creating tmp directory"
    mkdir tmp
fi

# Make sure process spawned by this script get killed again
# so they don't keep the bind() on a port
kill_tasks() {
    for f in gulp; do
        file="tmp/${f}.pid"
        if [ -f "$file" ]; then
            pid="$(cat "$file")"
            echo "RhymeBin: killing $f (pid=$pid) ..."
            kill -9 "$pid"
            rm "$file"
        fi
    done
}

# Kill spawned processes on CTRL+C
trap kill_tasks INT

# There may still be processes there,
# We may have received SIGTERM last time
kill_tasks

echo "RhymeBin: killing previous processes, if they are still running"

echo "RhymeBin: Running gulp watch with live-reload ... "
gulp watch &

# save PID for gulp watch to kill it later
echo $! > tmp/gulp.pid

echo "RhymeBin: Running PHPs own webserver on 127.0.0.1:1337 WEBROOT=public/  ... "
php -S 127.0.0.1:1337 -t "$(dirname "${BASH_SOURCE[0]}")/public"
# no need to save PID of webserver because it doesn't fork
