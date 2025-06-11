#!/usr/bin/env bash

# Run deploy tasks
./laravel-deploy.sh

# Start nginx + php-fpm server (from the richarvey image)
echo "Starting nginx + php-fpm..."
exec /usr/local/bin/start-nginx
