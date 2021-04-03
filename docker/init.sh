#!/usr/bin/env bash

echo "Installing Onlinemarket Work ..."
cd /home/onlinemarket.work
php composer.phar update

echo "Setting up web links ..."
ln -f -s /home/sandbox/public /srv/www/sandbox
ln -f -s /home/onlinemarket.work/public /srv/www/onlinemarket.work
ln -f -s /srv/repo/guestbook/public /srv/www/guestbook
ln -f -s /srv/repo/onlinemarket.complete/public /srv/www/onlinemarket.complete

echo "Setting permissions ..."
chown apache:apache /srv/www
chgrp apache /srv/www/*
chown -R apache:apache /srv/repo
chmod -R 775 /srv/repo
chgrp -R apache /home/sandbox
chmod -R 775 /home/sandbox
chgrp -R apache /home/onlinemarket.work
chmod -R 775 /home/onlinemarket.work

echo "Initializing MySQL, PHP-FPM and Apache ... "
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start

lfphp --mysql --phpfpm --apache
