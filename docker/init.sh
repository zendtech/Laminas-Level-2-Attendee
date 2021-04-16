#!/usr/bin/env bash

echo "Running composer update ..."
cd /home/guestbook
php composer.phar update
cd /home/onlinemarket.work
php composer.phar update
cd /home/onlinemarket.complete
php composer.phar update
cd /home/laminas-advanced
php composer.phar update

echo "Setting permissions ..."
chown apache /srv/www
chgrp -R apache /home/*
chmod -R 775 /home/*

echo "Initializing MySQL, PHP-FPM and Apache ... "
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start

lfphp --mysql --phpfpm --apache
