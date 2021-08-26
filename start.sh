#! /bin/bash

clear
reset

BUILD=local
APP_NAME=zgexcell

project_path="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
echo "project_path = ${project_path}"

if [[ -z "$(ls -A ${project_path}/src/vendors/phpunit)" ]]; then
  rm -rf "${project_path}/src/vendors/phpunit"
  wget https://phar.phpunit.de/phpunit-9.5.phar -P "${project_path}/src/vendors/phpunit"
fi


docker-compose -f docker/docker-compose.yml up