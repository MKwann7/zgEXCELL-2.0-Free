#! /bin/bash

clear
reset

BUILD=local
APP_NAME=zgexcell

project_path="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
echo "project_path = ${project_path}"

#if [[ "$docker images -q ${APP_NAME}-app-${BUILD} 2> /dev/null" == "" ]]; then
#  docker buildx prune --force
#  DOCKER_BUILDKIT=1 docker build --no-cache -rm --force-rm=true -t ${APP_NAME}-app-${BUILD}:latest --file="./docker/"
#
#fi

rm -rf "${project_path}/src/vendors/phpunit"
wget https://phar.phpunit.de/phpunit-9.5.phar -P "${project_path}/src/vendors/phpunit"

docker-compose -f docker/docker-compose.yml up