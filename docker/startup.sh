#!/bin/sh

set -e

echo "Setting permissions for storage and bootstrap/cache..."
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/bootstrap/cache
echo "Permissions set."

echo "Waiting for PostgreSQL to be available..."
while ! nc -z db 5432; do
  echo "PostgreSQL is unavailable - sleeping"
  sleep 1
done
echo "PostgreSQL is up - continuing..."

if [ ! -f ".env" ]; then
  echo "Creating .env file from .env.example..."
  cp .env.example .env
  echo ".env file created."
else
  echo ".env file already exists."
fi

echo "Generating application key..."
php artisan key:generate
echo "Application key generated."

echo "Running database migrations and seeding..."
php artisan migrate --force --seed
echo "Migrations and seeding complete."

echo "Starting supervisor..."

/usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisor.conf