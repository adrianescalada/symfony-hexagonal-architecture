#!/bin/bash

# Optional in local
# rm -f composer.lock && rm -f .env && rm -Rf vendor
# docker cp backend-php-1:/var/www/symfony/vendor vendor
# php bin/console cache:clear

# Install Composer dependencies
composer install --no-scripts --no-interaction

cp .env.example .env
php bin/console cache:clear
php bin/console doctrine:migrations:migrate
php bin/console app:create-entities

# Start the web server
php-fpm