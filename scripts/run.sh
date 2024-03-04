#! /bin/bash

clear
reset

BUILD=local
APP_NAME=excell

ls -al

project_path="$( cd "$( dirname "${BASH_SOURCE[0]//scripts\/}" )" &> /dev/null && pwd )"
echo "project_path = ${project_path}"

if [[ -z "$(ls -A ${project_path}/src/engine)" ]]; then
  mkdir "${project_path}/src/engine"
  cd "${project_path}/src/engine"
  git clone https://github.com/MKwann7/zgXCELL-Core .
  cd "${project_path}/"
fi

if [[ -z "$(ls -A ${project_path}/src/vendors/phpunit)" ]]; then
  rm -rf "${project_path}/src/vendors/phpunit"
  wget https://phar.phpunit.de/phpunit-9.5.phar -P "${project_path}/src/vendors/phpunit"
fi

cd ../
mkdir -p logs
mkdir -p list
mkdir -p list/commands
mkdir -p storage
mkdir -p tmp
chown -R mkwann7:mkwann7 list
chown -R mkwann7:mkwann7 list/commands
chown -R mkwann7:mkwann7 tmp
chown -R mkwann7:mkwann7 logs
chown -R mkwann7:mkwann7 storage
chmod -R 777 list
chmod -R 777 list/commands
chmod -R 777 tmp
chmod -R 777 logs
chmod -R 777 storage
cd code

docker-compose -f docker/docker-compose.local.yml --project-name ${APP_NAME} up --build