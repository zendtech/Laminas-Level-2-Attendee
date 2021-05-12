#!/usr/bin/env bash
cp -r /srv/laminas-api-tools /home
init.sh --init --perms --start
lfphp --mysql --phpfpm --apache
