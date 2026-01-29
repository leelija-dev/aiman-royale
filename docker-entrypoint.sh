#!/bin/sh

set -e

DB_HOST=${DB_HOST:-mariadb}
DB_PORT=${DB_PORT:-3306}

echo "Waiting for database at ${DB_HOST}:${DB_PORT} to be ready..."
until nc -z "$DB_HOST" "$DB_PORT" 2>/dev/null; do
    echo "${DB_HOST} is unavailable - sleeping"
    sleep 2
done

echo "Database ${DB_HOST}:${DB_PORT} is up - executing commands"

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

echo "Application is ready!"

exec "$@"

