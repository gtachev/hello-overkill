#!/bin/bash

echo "Downloading latest composer.phar..."

wget -N https://getcomposer.org/composer.phar

echo "Installing composer dependencies..."
php composer.phar install

echo "Deleting application cache..."
rm -rf data/cache/*

echo "Deleting assets..."
rm -rf public/assets/*

echo "Building assets..."
php public/index.php assetic build

echo "Deleting application cache..."
rm -rf data/cache/*

echo "Build finished!"
