#!/bin/bash

echo "Deleting application cache..."
rm -rf data/cache/*

echo "Deleting assets..."
rm -rf public/assets/*

echo "Building assets..."
php public/index.php assetic build

echo "Deleting application cache..."
rm -rf data/cache/*

echo "Build finished!"
