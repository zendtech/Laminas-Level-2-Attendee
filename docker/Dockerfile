FROM asclinux/linuxforphp-8.2-ultimate:7.4-nts
MAINTAINER doug@unlikelysource.com
COPY index.html /srv/www
COPY favicon.ico /srv/www
COPY phpmyadmin_install.sh /tmp
COPY httpd-laminas-2.conf /etc/httpd/extra
COPY zfcourse.sql /tmp
COPY init.sh /tmp
RUN \
    echo "Configuring Apache ..." && \
    echo "ServerName laminas" >> /etc/httpd/httpd.conf && \
    echo "Include /etc/httpd/extra/httpd-laminas-2.conf" >> /etc/httpd/httpd.conf
RUN \
    echo "Installing Laminas API Tools ..." && \
    cd /srv && \
    wget https://getcomposer.org/composer.phar && \
    php composer.phar create-project laminas-api-tools/api-tools-skeleton laminas-api-tools && \
    chown -R apache /srv/laminas-api-tools && \
    chmod -R 775 /srv/laminas-api-tools
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
CMD lfphp --mysql --phpfpm --apache
