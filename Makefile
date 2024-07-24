SHELL := /bin/bash

# Executables (local)
DOCKER_COMP = docker compose --env-file .env

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Environment variables
XDEBUG_ENV = --env XDEBUG_SESSION=1 --env PHP_IDE_CONFIG="serverName=symfony"

# Get host user ID and group ID
HOST_UID := $(shell id -u)
HOST_GID := $(shell id -g)

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP) bin/console
PHPUNIT  = $(PHP) bin/phpunit
PHPUNIT_XDEBUG = $(DOCKER_COMP) exec $(XDEBUG_ENV) php php bin/phpunit


# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc test tests xdebug

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Configuration 🤖 ———————————————————————————————————————————————————————————————
setup: ## prepares app for local usage
	@$(MAKE) setup-local

setup-local:
	@$(MAKE) build
	@$(DOCKER_COMP) up --pull always -d --wait

setup-tests:
	@$(MAKE) drop-test-db
	@$(MAKE) create-test-db
	@$(MAKE) migrate-test-db

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

start: build up ## Build and start the containers

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

xdebug-enable:
	@$(MAKE) down -s
	@XDEBUG_MODE=debug $(MAKE) up -s

xdebug-disable: down up

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

sh: ## Connect to the FrankenPHP container
	@$(PHP_CONT) sh

bash: ## Connect to the FrankenPHP container via bash so up and down arrows go to previous commands
	@$(PHP_CONT) bash

fix-file-permissions:
	docker compose run --rm php chown -R $(HOST_UID):$(HOST_GID) .

## —— Tests 🔴🟢 ————————————————————————————————————————————————————————————————
tests:
	@$(PHPUNIT)

test:
	@$(PHPUNIT) $(filter-out $@,$(MAKECMDGOALS))

test-by-filter:
	@$(PHPUNIT) --filter $(filter-out $@,$(MAKECMDGOALS))

debug-test:
	@$(PHPUNIT_XDEBUG) $(filter-out $@,$(MAKECMDGOALS))

debug-test-by-filter:
	@$(PHPUNIT_XDEBUG) --filter $(filter-out $@,$(MAKECMDGOALS))

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(COMPOSER) $(filter-out $@,$(MAKECMDGOALS))

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(SYMFONY) $(filter-out $@,$(MAKECMDGOALS))

cc:
	@$(SYMFONY) c:c

entity:
	@$(SYMFONY) make:entity
	$(MAKE) fix-file-permissions

create-db:
	@$(SYMFONY) doctrine:database:create

drop-db:
	@$(SYMFONY) doctrine:database:drop --force

diff:
	@$(SYMFONY) doctrine:migration:diff

validate-db-schema:
	@$(SYMFONY) doctrine:schema:validate

empty-migration:
	@$(SYMFONY) doctrine:migrations:generate

migrate:
	@$(SYMFONY) doctrine:migration:migrate

migrate-no-interaction:
	@$(SYMFONY) doctrine:migration:migrate -n

migrate-prev:
	@$(SYMFONY) doctrine:migrations:migrate prev

create-test-db:
	@$(SYMFONY) doctrine:database:create -n --env=test

drop-test-db:
	@$(SYMFONY) doctrine:database:drop -n --env=test --force

migrate-test-db:
	@$(SYMFONY) doctrine:migration:migrate -n --env=test

migrate-prev-test-db:
	@$(SYMFONY) doctrine:migrations:migrate prev -n --env=test

load-fixtures:
	@$(SYMFONY) doctrine:fixtures:load

load-fixtures-no-interaction:
	@$(SYMFONY) doctrine:fixtures:load -n

## —— Tools 🔧 ———————————————————————————————————————————————————————————————
cs-fixer:
	@$(COMPOSER) exec "php-cs-fixer fix"

api-docs:
	@$(SYMFONY) api:openapi:export --output=swagger_docs.json

