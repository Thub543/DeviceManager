#!/bin/bash
# Description: Runs the migration and starts the web server.
# Replace config in .env with environment variables (-e in docker run)
sed -i "s/^DB_HOST=.*/DB_HOST=$DB_HOST/g" /var/www/html/.env
sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/g" /var/www/html/.env
sed -i "s/^DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/g" /var/www/html/.env
sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/g" /var/www/html/.env

php /var/www/html/artisan migrate:fresh --seed
apachectl -D FOREGROUND
