#!/usr/bin/env bash
set -e

# Run database migrations and seed if needed
echo "Running database migrations..."
php artisan migrate --force || true

# Clear and cache configurations for production performance
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in foreground
echo "Starting Apache..."
apache2-foreground
