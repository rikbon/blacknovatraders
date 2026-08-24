#!/usr/bin/env bash
set -e

# Wait for MySQL / MariaDB if configured
if [ -n "$BNT_DATABASE_HOST" ] && [ "$BNT_DATABASE_HOST" != "localhost" ]; then
    echo "Waiting for database ($BNT_DATABASE_HOST:${BNT_DATABASE_PORT:-3306}) to be ready..."
    until mysqladmin ping -h "$BNT_DATABASE_HOST" -P "${BNT_DATABASE_PORT:-3306}" -u "${BNT_DATABASE_USERNAME:-root}" --password="${BNT_DATABASE_PASSWORD:-root}" --skip-ssl --silent 2>/dev/null; do
        sleep 2
    done
    echo "Database is ready."
fi

# Auto-install composer dependencies if vendor/autoload.php is missing
if [ ! -f "/app/vendor/autoload.php" ] && [ -f "/app/composer.json" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist
fi

exec "$@"
