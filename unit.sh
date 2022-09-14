#! /bin/bash

docker exec excell-app php8 /app/excell/code/vendors/phpunit/phpunit-9.5.phar /app/excell/code/ --bootstrap /app/excell/code/engine/system.load.php