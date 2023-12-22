DOCKER_SERVER = docker compose
CONTAINER_PHP = server
EXEC_IN_CONTAINER_PHP = $(DOCKER_SERVER) exec -u ${USERID}:${GROUPID} $(CONTAINER_PHP) bash -c

USERID=$(shell id -u)
GROUPID=$(shell id -g)

DATABASE_DELAY = 2

help: ## Ayuda
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

build: ## Construye los contenedores
	$(DOCKER_SERVER) build

up: ## Levanta los contenedores
	$(DOCKER_SERVER) up -d nginx
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

test-unit: ## Ejecuta los tests unitarios
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpunit --do-not-cache-result --colors=always tests/Unit"

test-integration: ## Ejecuta los tests de integración
	$(DOCKER_SERVER) up -d database_test
	sleep $(DATABASE_DELAY)
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpunit --do-not-cache-result --colors=always tests/Integration"
	$(DOCKER_SERVER) stop database_test
	$(DOCKER_SERVER) rm -f database_test

test-acceptance: ## Ejecuta los tests de aceptación
	$(DOCKER_SERVER) up -d database_test
	sleep $(DATABASE_DELAY)
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpunit --do-not-cache-result --colors=always tests/Acceptance"
	$(DOCKER_SERVER) stop database_test
	$(DOCKER_SERVER) rm -f database_test

test-coverage: ## Ejecuta los tests con cobertura
	$(DOCKER_SERVER) up -d database_test
	sleep $(DATABASE_DELAY)
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/phpunit --do-not-cache-result --colors=always --coverage-html=reports/coverage tests"
	$(DOCKER_SERVER) stop database_test
	$(DOCKER_SERVER) rm -f database_test

test-mutation: test-unit ## Ejecuta los tests con mutación
	$(DOCKER_SERVER) up -d database_test
	sleep $(DATABASE_DELAY)
	$(EXEC_IN_CONTAINER_PHP) "vendor/bin/infection --only-covered"
	$(DOCKER_SERVER) stop database_test
	$(DOCKER_SERVER) rm -f database_test

.PHONY: tests