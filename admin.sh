#!/usr/bin/env bash
# Usage: admin.sh up|down|shell
echo "Usage: admin.sh up|down|build|shell"
export CONTAINER="laminas_2"
if [[ "$1" = "up" ]]; then
    docker-compose up -d
elif [[ "$1" = "down" ]]; then
    docker-compose down
    chown -R $USER:$USER *
elif [[ "$1" = "build" ]]; then
    docker-compose build --force-rm --no-cache
elif [[ "$1" = "shell" ]]; then
    docker exec -it $CONTAINER /bin/bash
fi
