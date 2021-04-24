#!/usr/bin/env bash
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start
lfphp --mysql --phpfpm --apache
