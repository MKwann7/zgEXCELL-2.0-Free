#! /bin/bash

project_path="$( cd "$( dirname "${BASH_SOURCE[0]//scripts\/}" )" &> /dev/null && pwd )"
echo "Uninstalling project at path: ${project_path}"

docker-compose -f docker/docker-compose.local.yml down --volumes

echo "Removing database: ${project_path}/docker/mysql-data/*"
sudo chmod -R 777 docker/mysql-data
sudo rm -rf docker/mysql-data/*
sudo rm -rf ../tmp/uploads
sudo rm -rf ../tmp
sudo rm -rf ../storage
sudo rm -rf ../logs
sudo rm -rf ../list

docker rm excell-api excell-app excell-process excell-socket excell-db excell-pg
docker rmi excell_api excell_process excell_socket excell_app
echo "y" | docker system prune --volumes -a

echo "excell application removed!"