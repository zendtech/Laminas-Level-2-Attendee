#!/usr/bin/env bash
# Usage: phpmyadmin_install.sh VERSION

echo "Installing Onlinemarket Work ..."
cd /home/onlinemarket.work
composer update

echo "Setting up Apache ..."
echo "ServerName laminas" >> /etc/httpd/httpd.conf
ln -f -s /home/sandbox/public /srv/www/sandbox
ln -f -s /home/onlinemarket.work/public /srv/www/onlinemarket.work
ln -f -s /srv/repo/guestbook/public /srv/www/guestbook
ln -f -s /srv/repo/onlinemarket.complete/public /srv/www/onlinemarket.complete

echo "Setting permissions ..."
chown apache:apache /srv/www
chgrp apache /srv/www/*
chgrp -R apache /srv/repo
chmod -R 775 /srv/repo
chgrp -R apache /home/onlinemarket.work
chmod -R 775 /home/onlinemarket.work

echo "Initializing MySQL, PHP-FPM and Apache ... "
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start

lfphp --mysql --phpfpm --apache
