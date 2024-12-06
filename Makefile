up: ## Start the docker containers
	docker compose up -d

down: ## Stop the docker containers
	docker compose down

restart: down up ## Restart the docker containers

logs: ## Show the logs of the containers
	docker compose logs -f

composer-install: ## Install the composer dependencies
	docker compose exec app composer install

composer-update: ## Update the composer dependencies
	docker compose exec app composer update

composer-require: ## Add a new composer dependency
	docker compose exec app composer require $(package)

composer-require-dev: ## Add a new composer dependency as a dev dependency
	docker compose exec app composer require --dev $(package)

phpstan: ## Run the phpstan static analysis
	docker compose exec app ./vendor/bin/phpstan analyse src

phpcs: ## Run the phpcs code sniffer
	docker compose exec app ./vendor/bin/phpcs --standard=PSR12 src

phpcbf: ## Run the phpcbf code fixer
	docker compose exec app ./vendor/bin/phpcbf --standard=PSR12 src