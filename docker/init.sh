#!/usr/bin/env bash

echo "Setting permissions ..."
chown apache /srv/www
chgrp -R apache /home/sandbox
chmod -R 775 /home/sandbox
chown -R apache /home/guestbook/data
chown -R apache /home/guestbook/public/captcha
chown -R apache /home/onlinemarket.work/data
chown -R apache /home/onlinemarket.work/public/captcha
chown -R apache /home/onlinemarket.complete/data
chown -R apache /home/onlinemarket.complete/public/captcha
ln -s /srv/laminas-api-tools/module /home/laminas-api-tools/module

echo "Initializing MySQL, PHP-FPM and Apache ... "
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start

lfphp --mysql --phpfpm --apache
