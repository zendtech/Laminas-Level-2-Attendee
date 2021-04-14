#!/usr/bin/env bash
# Usage: admin.sh up|down|shell
echo "Usage: admin.sh up|down|build|ls|shell"
export CONTAINER="laminas_2"
if [[ "$1" = "up" ]]; then
    docker-compose up -d
    docker exec $CONTAINER /bin/bash -c "chgrp -R apache /home/*"
    docker exec $CONTAINER /bin/bash -c "chmod -R 775 /home/*"
    docker exec $CONTAINER /bin/bash -c "/etc/init.d/mysql start"
    docker exec $CONTAINER /bin/bash -c "/etc/init.d/php-fpm start"
    docker exec $CONTAINER /bin/bash -c "/etc/init.d/httpd start"
elif [[ "$1" = "down" ]]; then
    docker-compose down
    sudo chown -R $USER:$USER *
elif [[ "$1" = "build" ]]; then
    docker-compose build --force-rm --no-cache
elif [[ "$1" = "shell" ]]; then
    docker exec -it $CONTAINER /bin/bash
elif [[ "$1" = "ls" ]]; then
    docker container ls
fi
