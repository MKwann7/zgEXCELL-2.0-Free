#! /bin/bash


docker container rm -f $(docker container ls -a -q)
docker rmi -f $(docker images -a -q)
docker volume rm -f $(docker volume ls -q)
docker system prune --volumes

echo "excell application removed"