DOCKER = docker compose -f ./docker-compose.yml -p s6es
EXEC = docker compose exec -ti php

.PHONY: start
start: erase build up

.PHONY: stop
stop:
	$(DOCKER) stop

.PHONY: erase
erase:
	$(DOCKER) stop
	$(DOCKER) rm -v -f

.PHONY: build
build:
	$(DOCKER) build

.PHONY: up
up:
	$(DOCKER) up -d

.PHONY: down
down:
	$(DOCKER) down -v
