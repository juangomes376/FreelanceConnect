#!/bin/bash
php bin/console asset-map:compile
php bin/console tailwind:build --env=prod
php bin/console cache:clear --env=dev --no-debug