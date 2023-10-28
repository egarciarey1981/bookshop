DOCKER_COMPOSE = docker-compose
CONTAINER_PHP = php
EXEC_IN_CONTAINER_PHP = $(DOCKER_COMPOSE) exec $(CONTAINER_PHP) bash -c

help: ## Ayuda
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

build: ## Construye los contenedores
	$(DOCKER_COMPOSE) build

up: ## Levanta los contenedores
	$(DOCKER_COMPOSE) up -d
	make composer-install

stop: ## Detiene los contenedores
	docker-compose stop

down: ## Detiene y elimina los contenedores
	docker-compose down

composer-install: composer.json ## Instala dependencias de composer
	$(EXEC_IN_CONTAINER_PHP) "cd //code && composer install"

composer-update: ## Actualiza dependencias de composer
	$(EXEC_IN_CONTAINER_PHP) "cd //code && composer update"

web: ## Ejecuta el cliente web
	php -S localhost:8081 -t client
