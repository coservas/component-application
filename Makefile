ROOT_DIR := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
include $(ROOT_DIR)/.mk-lib/common.mk

include .env
-include .env.local
export

DC_FILE := $(DOCKER_COMPOSE_FILE)
DC := $(DOCKER_COMPOSE) -f $(DC_FILE)
DC_EXEC := $(DC) exec

.PHONY:
	help status ps
	build clean start stop restart
	bash bash-fpm bash-db bash-nginx

### data ###
build: ##@data Build all or c=<name> services
	@$(DC) build $(c)

clean: confirm ##@data Stop containers and removing containers, networks, volumes, and images
	@$(DC) down
### data ###


### running ###
start: ##@running Start all or c=<name> containers in background
	@$(DC) up -d $(c)

stop: ##@running Stop all or c=<name> containers
	@$(DC) stop $(c)

restart: ##@running Restart all or c=<name> containers
	@$(DC) stop $(c)
	@$(DC) up -d $(c)
### running ###


### shell ###
db: ##@console Exec mariadb
	@$(DC_EXEC) db mysql -u $(DB_USER) -p$(DB_PASS) $(DB_DATABASE)

db-root: ##@console Exec mariadb as root
	@$(DC_EXEC) db mysql -u root -p$(DB_ROOT_PASS) $(DB_DATABASE)

bash: bash-fpm ##@console Alias bash-fpm

bash-db: ##@console Exec bash on mariadb
	@$(DC_EXEC) db bash

bash-fpm: ##@console Exec bash on fpm
	@$(DC_EXEC) fpm bash

bash-nginx: ##@console Exec bash on nginx
	@$(DC_EXEC) nginx bash
### shell ###


### information ###
ps: status ##@info Alias of status

status: ##@info Show status of containers
	@$(DC) ps

logs: ##@info Show all or c=<name> logs of containers
	@$(DC) logs -f $(c)
### information ###