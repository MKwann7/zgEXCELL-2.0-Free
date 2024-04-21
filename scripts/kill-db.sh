#! /bin/bash

project_path="$( cd "$( dirname "${BASH_SOURCE[0]//scripts\/}" )" &> /dev/null && pwd )"
echo "Uninstalling excell app at path: ${project_path}"

docker-compose -f docker/docker-compose.local.yml down --volumes

docker rm excell-db

echo "y" | docker volume prune

echo "Removing database: ${project_path}/docker/mysql-data/*"
sudo chmod -R 777 docker/mysql-data
sudo rm -rf docker/mysql-data/*

echo "excell app removed!"