ROOT_DIR := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
include $(ROOT_DIR)/.mk-lib/common.mk

include .env
-include .env.local
export

DOCKER_DIR := $(ROOT_DIR)
DC_FILE := $(DOCKER_DIR)/docker-compose.yml
DC := $(DOCKER_COMPOSE) -f $(DC_FILE)
DC_EXEC := $(DC) exec

.PHONY:
	help status ps
	build clean start stop restart
	bash bash-fpm bash-db bash-nginx

### data ###
build: ## Build all or c=<name> services
	@$(DC) build $(c)

clean: ## Stop containers and removing containers, networks, volumes, and images
	@$(DC) down
### data ###


### running ###
start: ## Start all or c=<name> containers in background
	@$(DC) up -d $(c)

stop: ## Stop all or c=<name> containers
	@$(DC) stop $(c)

restart: ## Restart all or c=<name> containers
	@$(DC) stop $(c)
	@$(DC) up -d $(c)
### running ###


### shell ###
db: ## Exec mariadb
	@$(DC_EXEC) db mysql -u $(DB_USER) -p$(DB_PASS) $(DB_DATABASE)

db-root: ## Exec mariadb as root
	@$(DC_EXEC) db mysql -u root -p$(DB_ROOT_PASS) $(DB_DATABASE)

bash: bash-fpm ## Alias bash-fpm
bash-mysql: bash-db ## Alias bash-db
bash-mariadb: bash-db ## Alias bash-db

bash-db: ## Exec bash on mariadb
	@$(DC_EXEC) db bash

bash-fpm: ## Exec bash on fpm
	@$(DC_EXEC) fpm bash

bash-nginx: ## Exec bash on nginx
	@$(DC_EXEC) nginx bash
### shell ###


### information ###
ps: status ## Alias of status

status: ## Show status of containers
	@$(DC) ps

logs: ## Show all or c=<name> logs of containers
	@$(DC) logs -f $(c)
### information ###