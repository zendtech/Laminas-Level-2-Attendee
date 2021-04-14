#!/usr/bin/env bash

echo "Setting permissions ..."
chown apache /srv/www
chgrp -R apache /home/*
chmod -R 775 /home/*

echo "Initializing MySQL, PHP-FPM and Apache ... "
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start

lfphp --mysql --phpfpm --apache
