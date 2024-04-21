#! /bin/bash

project_path="$( cd "$( dirname "${BASH_SOURCE[0]//scripts\/}" )" &> /dev/null && pwd )"
echo "Uninstalling excell app at path: ${project_path}"

docker-compose -f docker/docker-compose.local.yml down --volumes

docker rm excell-app
docker rmi excell_app

echo "y" | docker volume prune

echo "excell app removed!"