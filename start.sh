#!/bin/bash
composer install --ignore-platform-reqs --no-progress \
&& vendor/bin/phinx migrate \
&& php /var/www/start.php start > /var/www/phplog.log \
& cd /var/www/frontend \
&& npm install \
&& npm run serve > npmlog.log \
&& php-fpm