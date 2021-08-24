#!/bin/bash
php /var/www/start.php stop && php /var/www/start.php start && cd /var/www/frontend && killall -9 node && npm run serve && php-fpm