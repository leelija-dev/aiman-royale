#!/bin/sh

set -e

echo "Waiting for MariaDB to be ready..."
until nc -z mariadb 3306 2>/dev/null; do
    echo "MariaDB is unavailable - sleeping"
    sleep 2
done

echo "MariaDB is up - executing commands"

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

echo "Application is ready!"

exec "$@"

