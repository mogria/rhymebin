#!/bin/bash
php -S 127.0.0.1:1337 -t "$(dirname "${BASH_SOURCE[0]}")/public"
