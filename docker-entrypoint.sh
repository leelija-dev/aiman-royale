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

# Prepare only the Laravel runtime directories.
# Do not recursively change application files or uploaded data.

for dir in \
    /var/www/html/storage \
    /var/www/html/storage/framework \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache
do
    mkdir -p "$dir"
    chown www-data:www-data "$dir"
    chmod 2775 "$dir"
done

# Allow group write access for newly created files and directories.
umask 0002

echo "Laravel runtime directory permissions verified."
echo "Application is ready!"

exec "$@"