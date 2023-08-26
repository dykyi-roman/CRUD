env = local
workdir = ./infrastructure/env/$(env)
config = docker-compose.yml
php = app-php-$(env)

placeholder:
	@echo "-----------------------------------------------------------------------------------"
	@echo "| COMMAND                     | DESCRIPTION                                       |"
	@echo "-----------------------------------------------------------------------------------"
	@echo "| install                     | Install and start all services                    |"
	@echo "| up / start                  | Start all services                                |"
	@echo "| down / stop                 | Stop and remove all containers                    |"
	@echo "| restart                     | Restart all services                              |"
	@echo "| prune                       | Remove containers with volumes, images, networks  |"
	@echo "| --------------------------- | ------------------------------------------------- |"
	@echo "| backend-up / backend-start  | Start backend services                            |"
	@echo "| backend-down / backend-stop | Stop backend services                             |"
	@echo "| backend-migration-migrate   | Migrate migrations                                |"
	@echo "| backend-migration-generate  | Generate migrations                               |"
	@echo "| ----------------------------| ------------------------------------------------- |"
	@echo "| backend-console             | CLI                                               |"
	@echo "| backend-composer            | Run composer                                      |"
	@echo "| backend-cc                  | Clear cache                                       |"
	@echo "| ----------------------------| ------------------------------------------------- |"
	@echo "| backend-deptrac             | Run deptrac                                       |"
	@echo "| backend-phpcs               | Run phpcs                                         |"
	@echo "| backend-psalm               | Run psalm                                         |"
	@echo "| backend-phpstan             | Run phpstan                                       |"
	@echo "| backend-test-run            | Run test [unit, functional]                       |"
	@echo "| backend-coverage-run        | Run test coverage [unit, functional]              |"
	@echo "| postman-test                | Run postman tests                                 |"
	@echo "| ci                          | Run all check command before commit               |"
	@echo "| --------------------------- | ------------------------------------------------- |"


install:
	docker network inspect app-network --format {{.Id}} 2>/dev/null || docker network create app-network
	cd $(workdir) && docker compose -f $(config) up -d
	docker exec -it $(php) bash -c "composer install"
	docker exec -it $(php) bash -c "php bin/console doctrine:migrations:migrate -n"
up:
	cd $(workdir) && docker compose -f $(config) up -d

down:
	cd $(workdir) && docker compose -f $(config) down

start: up

stop: down

restart:
	cd $(workdir) && docker compose -f $(config) restart

prune:
	cd $(workdir) && docker compose -f $(config) -v --remove-orphans --rmi all
	cd $(workdir) && docker network remove app-network

backend-up:
	cd $(workdir) && docker compose -f $(config) up -d

backend-down:
	cd $(workdir) && docker compose -f $(config) down

backend-start: backend-up

backend-stop: backend-down

backend-migration-generate:
	docker exec -it $(php) bash -c "php bin/console doctrine:migrations:generate -n"
	@echo "Migration generated!"

backend-migration-migrate:
	docker exec -it $(php) bash -c "php bin/console doctrine:migrations:migrate -n $(filter-out $@,$(MAKECMDGOALS))"
	@echo "Migration migrated!"

backend-console:
	docker exec -it $(php) bash -c "php bin/console $(filter-out $@,$(MAKECMDGOALS))"

backend-composer:
	docker exec -it $(php) bash -c "composer $(filter-out $@,$(MAKECMDGOALS))"

backend-cc:
	docker exec -it $(php) bash -c "php bin/console cache:clear"

backend-deptrac:
	docker exec -it $(php) bash -c "php vendor/bin/deptrac analyze --config-file=./config/tools/deptrac.yaml --no-cache"
	@echo "deptrac done"

backend-phpcs:
	docker exec -it $(php) bash -c "php vendor/bin/php-cs-fixer fix -v --using-cache=no --config=./config/tools/.php-cs-fixer.php"
	@echo "phpcs done"

backend-psalm:
	docker exec -it $(php) bash -c "php vendor/bin/psalm -c ./config/tools/psalm.xml --no-cache"
	@echo "psalm done"

backend-phpstan:
	docker exec -it $(php) bash -c "php vendor/bin/phpstan analyse src --configuration=./config/tools/phpstan.neon"

backend-test-run:
	docker exec -it $(php) bash -c "php vendor/bin/codecept build -c ./config/tools/codeception.yml && php vendor/bin/codecept run -c ./config/tools/codeception.yml $(filter-out $@,$(MAKECMDGOALS))"
	@echo "Test done!"

backend-test-coverage-run:
	docker exec -it $(php) bash -c "php vendor/bin/codecept build -c ./config/tools/codeception.yml && php vendor/bin/codecept run -c ./config/tools/codeception.yml $(filter-out $@,$(MAKECMDGOALS)) --coverage --coverage-html"
	@echo "Test coverage done!"

postman-test:
	cd $(workdir) && docker compose -f $(config) run --rm newman

ci:
	$(MAKE) backend-phpcs
	$(MAKE) backend-phpstan
	$(MAKE) backend-psalm
	$(MAKE) backend-deptrac
	docker exec -it $(php) bash -c "php vendor/bin/codecept build -c ./config/tools/codeception.yml && php vendor/bin/codecept run -c ./config/tools/codeception.yml unit"
	docker exec -it $(php) bash -c "php vendor/bin/codecept build -c ./config/tools/codeception.yml && php vendor/bin/codecept run -c ./config/tools/codeception.yml functional"
	@echo "CI done!"