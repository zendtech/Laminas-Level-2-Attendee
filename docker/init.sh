#!/usr/bin/env bash
# Usage: phpmyadmin_install.sh VERSION

echo "Installing Guestbook ..."
cd /home/guestbook
composer install

echo "Installing Onlinemarket Complete ..."
cd /home/onlinemarket.complete
composer install

echo "Installing Onlinemarket Work ..."
cd /home/onlinemarket.work
composer install

echo "Installing Laminas Advanced Examples ..."
cd /home/laminas_advanced
composer install

echo "Installing Laminas API Tools ... "
cd /home
if [[ -f "/home/laminas_api_tools" ]]; then
    cd laminas_api_tools
    composer update
elif
    composer create-project laminas-api-tools/api-tools-skeleton laminas_api_tools
fi

echo "Setting up Apache ..."
echo "ServerName laminas" >> /etc/httpd/httpd.conf
ln -f -s /home/sandbox/public /srv/www/sandbox
ln -f -s /home/guestbook/public /srv/www/guestbook
ln -f -s /home/onlinemarket.complete/public /srv/www/onlinemarket.complete

echo "Setting permissions ..."
chmod +x /tmp/*.sh
/tmp/reset_perms.sh

echo "Initializing MySQL, PHP-FPM and Apache ... "
/etc/init.d/mysql start
/etc/init.d/php-fpm start
/etc/init.d/httpd start

lfphp --mysql --phpfpm --apache
