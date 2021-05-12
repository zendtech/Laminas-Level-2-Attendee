FROM asclinux/linuxforphp-8.2-ultimate:7.4-nts
MAINTAINER doug@unlikelysource.com
COPY index.html /srv/www
COPY favicon.ico /srv/www
COPY phpmyadmin_install.sh /tmp
COPY httpd-laminas-2.conf /etc/httpd/extra
COPY zfcourse.sql /tmp
COPY init.sh /tmp
COPY startup.sh /tmp
RUN \
    echo "Configuring Apache ..." && \
    echo "ServerName laminas" >> /etc/httpd/httpd.conf && \
    echo "Include /etc/httpd/extra/httpd-laminas-2.conf" >> /etc/httpd/httpd.conf
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    /etc/init.d/mysql start && \
    sleep 3 && \
    mysql -uroot -v -e "CREATE DATABASE zfcourse;" && \
    mysql -uroot -v -e "CREATE USER 'laminas'@'localhost' IDENTIFIED BY 'password';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'laminas'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;" && \
    echo "Restoring sample database ..." && \
    mysql -uroot -e "SOURCE /tmp/zfcourse.sql;" zfcourse
RUN \
    echo "Installing phpMyAdmin ..." && \
    /tmp/phpmyadmin_install.sh
RUN \
    echo "Installing Laminas API Tools ..." && \
    cd /srv && \
    php composer.phar create-project laminas-api-tools/api-tools-skeleton laminas-api-tools && \
    cp composer.phar laminas-api-tools && \
    cd laminas-api-tools && \
    php composer.phar require -n laminas/laminas-i18n && \
    php composer.phar require -n laminas-api-tools/api-tools-documentation-swagger
RUN \
    echo "Setting PHP for development ..." && \
    echo "error_reporting=E_ALL ^ E_DEPRECATED" >>/etc/php.ini && \
    echo "display_errors=on" >>/etc/php.ini && \
    /etc/init.d/php-fpm restart
CMD /tmp/startup.sh
