#! /bin/bash

project_path="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
echo "project_path = ${project_path}"

docker container rm -f $(docker container ls -a -q)
docker rmi -f $(docker images -a -q)
docker volume rm -f $(docker volume ls -q)
docker system prune --volumes

rm -rf "${project_path}/docker/mysql-data/*"

echo "excell application removed"