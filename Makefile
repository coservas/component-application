ROOT_DIR := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
include $(ROOT_DIR)/.mk-lib/common.mk

include .env
-include .env.local
export

DC_FILE := docker/docker-compose.yml
DC := $(DOCKER_COMPOSE) -f $(DC_FILE)
DC_EXEC := $(DC) exec
QUIET := > /dev/null 2>&1

.PHONY:
	help status ps logs
	db db-root
	build clean start stop restart
	bash bash-fpm bash-db bash-nginx
	install

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
db: ##@console Database console
	@$(DC_EXEC) db mysql -u $(DB_USER) -p$(DB_PASS) $(DB_DATABASE)

# db-root: ##@console Database console as root
# 	@$(DC_EXEC) db mysql -u root -p$(DB_ROOT_PASS) $(DB_DATABASE)

bash: bash-fpm ##@console Alias bash-fpm

bash-db: ##@console Exec bash on database
	@$(DC_EXEC) db bash

bash-fpm: ##@console Exec bash on fpm
	@$(DC_EXEC) fpm sh

bash-nginx: ##@console Exec bash on nginx
	@$(DC_EXEC) nginx sh
### shell ###


### information ###
ps: status ##@info Alias of status

status: ##@info Show status of containers
	@$(DC) ps

logs: ##@info Show all or c=<name> logs of containers
	@$(DC) logs -f $(c)
### information ###


### inactive ###
TASK_COUNT := 5
install: # Install project
	@echo -e '\n'
	@echo '-------------------------------'
	@echo '| Installing, please wait ... |'
	@echo '| 1/$(TASK_COUNT) ...                     |'
	@make build $(QUIET)
	@echo '| 2/$(TASK_COUNT) ...                     |'
	@make restart $(QUIET)
	@echo '| 3/$(TASK_COUNT) ...                     |'
	@$(DC_EXEC) fpm composer install $(QUIET)
	@echo '| 4/$(TASK_COUNT) ...                     |'
	@$(DC_EXEC) fpm yarn install $(QUIET)
	@echo '| 5/$(TASK_COUNT) ...                     |'
	@$(DC_EXEC) fpm yarn build $(QUIET)
	@echo '| Done.                       |'
	@echo '-------------------------------'
	@echo 'Installation completed successfully!'
	@echo 'Now you can start the project in browser at 0.0.0.0:$(NGINX_PORT)'
	@echo -e '\n'
### inactive ###


### debug ###
watch:
	@$(DC_EXEC) fpm yarn watch
### debug ###