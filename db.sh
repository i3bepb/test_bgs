#!/usr/bin/env bash
# Запускаем только если есть .env
if [ -f .env ]; then
    # экспортируем переменные проекта
    export $(cat .env | sed 's/#.*//g' | xargs);
    commandArray=(
         "docker-compose exec -u root db psql -p ${POSTGRES_PORT} -h localhost -U ${POSTGRES_USER} -d $@"
    );
    for i in "${commandArray[@]}"; do
        echo -en "\033[33m$i\033[0m\n";
        eval "$i";
    done
else
    echo -en "\033[31mError: file .env not found!\031[0m\n";
fi