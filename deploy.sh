#!/bin/bash

set -e

if command -v "docker-compose" &> /dev/null; then
    DOCKER_COMPOSE="docker-compose"
elif docker compose version &> /dev/null; then
    DOCKER_COMPOSE="docker compose"
else
    echo "Error: Docker Compose is not installed." >&2
    exit 1
fi

while getopts "dp" option; do
  case "$option" in
    d) ENVIRONMENT="development"
       ;;
    p) ENVIRONMENT="production"
       ;;
    *) exit 1
       ;;
  esac
done

if [ -z ${ENVIRONMENT+x} ]; then
    echo "Environment flag missing. Use -d for development or -p for production";
    exit 1
fi

echo "Deploying to $ENVIRONMENT environment..."

$DOCKER_COMPOSE pull php
$DOCKER_COMPOSE up -d mariadb
sleep 5
if [ $ENVIRONMENT = "development" ]; then
    $DOCKER_COMPOSE run --rm php composer install
    $DOCKER_COMPOSE run --rm php npm install
else
    $DOCKER_COMPOSE run --rm php composer install --no-dev
    $DOCKER_COMPOSE run --rm php npm install --no-audit
fi
$DOCKER_COMPOSE run --rm php php artisan migrate --force
$DOCKER_COMPOSE run --rm php php artisan key:generate --force
$DOCKER_COMPOSE run --rm php php artisan db:seed --force
$DOCKER_COMPOSE run --rm php php artisan l5-swagger:generate
if [ "$ENVIRONMENT" = "development" ]; then
    $DOCKER_COMPOSE up
else
    $DOCKER_COMPOSE run --rm php npm run build
    $DOCKER_COMPOSE up -d php nginx
fi
