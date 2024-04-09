#!/bin/bash

# Start PHP-FPM
php-fpm

# Run composer install
composer install

# Generate JWT key pair
php bin/console lexik:jwt:generate-keypair

# Update database schema
php bin/console doctrine:schema:update --force --complete


