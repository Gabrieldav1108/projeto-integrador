#!/bin/sh

until nc -z laravel-app 9000; do
  sleep 2
done

exec nginx -g 'daemon off;'