include ./docker/.env

help: ## Show make help
	@echo "Project commands"
	@echo "\033[93mproject  \033[0m                         build docker & start docker & install composer dependencies"
	@echo "\033[93mbuild  \033[0m                           build docker"
	@echo "\033[93mstart  \033[0m                           start docker"
	@echo ""
	@echo "Console commands"
	@echo "\033[93mbash \033[0m                             open bash inside the app container"
	@echo "\033[93mcomposer-install \033[0m                 install composer dependencies"
	@echo ""
	@echo "Symfony commands"
	@echo "\033[93mmigration \033[0m                        make migration"
	@echo "\033[93mmigrate \033[0m                          migrate"

project:
	make build && make start && make composer-install
build:
	docker-compose -f docker/docker-compose.yml build
start:
	docker-compose  -f docker/docker-compose.yml up -d

bash:
	docker exec -it $(APP_NAME)-app /bin/bash
composer-install:
	docker exec -it $(APP_NAME)-app /bin/bash -c 'composer install'

migration:
	docker exec -it $(APP_NAME)-app /bin/bash -c 'symfony console make:migration'
migrate:
	docker exec -it $(APP_NAME)-app /bin/bash -c 'symfony console doctrine:migrations:migrate'
