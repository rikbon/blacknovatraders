# BlackNova Traders Makefile

COMPOSE=docker compose
ENV_FILE=.env

.PHONY: help up down restart ps logs php mysql composer-install test lint universe-create db-dump

help: ## Show this help message
	@echo "Available make commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

init: ## Initialize environment (.env) if missing
	@if [ ! -f $(ENV_FILE) ]; then cp .env.dist $(ENV_FILE) && echo ".env created from .env.dist"; else echo ".env already exists"; fi

up: init ## Start the entire container stack in background
	$(COMPOSE) up -d --build

down: ## Stop all containers and remove networks
	$(COMPOSE) down

down-v: ## Stop all containers and delete volumes (warning: resets DB)
	$(COMPOSE) down -v

restart: down up ## Restart the stack

ps: ## View running containers status
	$(COMPOSE) ps

logs: ## Follow logs from all containers
	$(COMPOSE) logs -f

logs-php: ## Follow PHP-FPM logs
	$(COMPOSE) logs -f php

logs-scheduler: ## Follow Scheduler game tick logs
	$(COMPOSE) logs -f scheduler

php: ## Open an interactive bash shell in the PHP container
	$(COMPOSE) exec php bash

mysql: ## Open interactive MySQL client inside the DB container
	$(COMPOSE) exec db mysql -uroot -proot bnt

composer-install: ## Run composer install in the PHP container
	$(COMPOSE) exec php composer install

composer-update: ## Run composer update in the PHP container
	$(COMPOSE) exec php composer update

lint: ## Run PHP syntax linting across all codebase files
	find . -type f -name "*.php" ! -path "./vendor/*" ! -path "./symphony_workspaces/*" -exec php -l {} +

test: ## Run PHPUnit automated test suite
	$(COMPOSE) exec php ./vendor/bin/phpunit

phpstan: ## Run PHPStan static analysis
	$(COMPOSE) exec php ./vendor/bin/phpstan analyse --configuration=phpstan.neon

universe-create: ## Initialize game universe and tables
	$(COMPOSE) exec php php create_universe.php

db-dump: ## Dump current database to backup.sql
	$(COMPOSE) exec db mysqldump -uroot -proot bnt > backup_$(shell date +%Y%m%d_%H%M%S).sql
