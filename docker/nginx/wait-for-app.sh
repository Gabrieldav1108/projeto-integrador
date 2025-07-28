#!/bin/sh
until nc -z laravel-app 9000; do
  echo "Waiting for PHP-FPM..."
  sleep 1
done
exec "$@"#!/bin/sh
until nc -z laravel-app 9000; do
  echo "Waiting for PHP-FPM..."
  sleep 1
done
exec "$@"