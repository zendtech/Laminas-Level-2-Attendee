FROM asclinux/linuxforphp-8.2-ultimate:7.4-nts
MAINTAINER doug@unlikelysource.com
RUN \
    echo "Cloning repo into container ..." && \
    cd /srv && \
    wget https://github.com/zendtech/Laminas-Level-2-Attendee/archive/refs/heads/master.zip && \
    unzip master.zip && \
    mv /srv/Laminas-Level-2-Attendee-master /srv/repo && \
    chmod +x /srv/repo/docker/*.sh && \
    cp /srv/repo/docker/index.html /srv/www
RUN \
    echo "Installing Composer 1.10 ..." && \
    rm -f composer.phar && \
    wget https://getcomposer.org/download/1.10.21/composer.phar && \
    echo "Installing guestbook ..." && \
    cd /srv/repo/guestbook && \
    cp ../composer.phar . && \
    php composer.phar update && \
    echo "Installing onlinemarket.complete ..." && \
    cd /srv/repo/onlinemarket.complete && \
    cp ../composer.phar . && \
    php composer.phar update && \
    echo "Installing laminas_advanced ..." && \
    cd /srv/repo/laminas_advanced && \
    cp ../composer.phar . && \
    php composer.phar update && \
    echo "Installing Laminas API Tools ..." && \
    cd /srv/repo && \
    php composer.phar create-project laminas-api-tools/api-tools-skeleton laminas_api_tools
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    /etc/init.d/mysql start && \
    sleep 5 && \
    mysql -uroot -v -e "CREATE DATABASE zfcourse;" && \
    mysql -uroot -v -e "CREATE USER 'laminas'@'localhost' IDENTIFIED BY 'password';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'laminas'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;" && \
    echo "Restoring sample database ..." && \
    mysql -uroot -e "SOURCE /srv/repo/docker/zfcourse.sql;" zfcourse
RUN \
    echo "Installing phpMyAdmin ..." && \
    /srv/repo/docker/phpmyadmin_install.sh
CMD /tmp/init.sh
