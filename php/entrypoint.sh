#!/bin/bash

# Run composer install
composer install

# Generate JWT key pair
php bin/console lexik:jwt:generate-keypair

# Start PHP-FPM
php-fpm
