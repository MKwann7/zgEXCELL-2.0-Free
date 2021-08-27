#! /bin/bash

docker-compose -f docker/docker-compose.local.yml down

docker rmi -f $(docker images -f "dangling=true" -q) 2> dev/null

docker images