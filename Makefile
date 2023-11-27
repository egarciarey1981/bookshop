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
	$(EXEC_IN_CONTAINER_PHP) "cd /var/www/html && composer install"

composer-update: ## Actualiza dependencias de composer
	$(EXEC_IN_CONTAINER_PHP) "cd /var/www/html && composer update"

phpstan: ## Ejecuta phpstan
ifdef FILES
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpstan analyse -c phpstan.neon $(FILES)"
else
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpstan analyse -c phpstan.neon"
endif

phpcs: ## Ejecuta phpcs
ifdef FILES
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpcs --standard=phpcs.xml $(FILES)"
else
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpcs --standard=phpcs.xml src"
endif

phpcbf: ## Ejecuta phpcbf
ifdef FILES
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpcbf --standard=phpcs.xml $(FILES)"
else
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpcbf --standard=phpcs.xml src"
endif

phpmd: ## Ejecuta phpmd
ifdef FILES
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpmd $(FILES) text phpmd.xml"
else
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpmd src text phpmd.xml"
endif

web: ## Ejecuta el cliente web
	php -S localhost:8081 -t client

test-unit: ## Ejecuta los tests
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpunit tests"

.PHONY: tests