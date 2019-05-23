#! /bin/bash
set -e

/bin/sed -i "s/_PHP_FPM_/$PHP_FPM/g" /etc/nginx/conf.d/default.conf

/usr/sbin/nginx -g 'daemon off; error_log /dev/stderr info;'
