# CRM 

## Install

```sh
docker-compose build
docker-compose up
```

## App build

```sh
docker-compose exec app sh
cd /var/www/app/
composer install
bin/console cache:clear
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load 
```

## Tests

```sh
bin/phpunit
```