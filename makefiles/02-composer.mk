composer-install: ## Install the composer dependencies
	docker compose exec app composer install

composer-update: ## Update the composer dependencies
	docker compose exec app composer update

composer-require: ## Add a new composer dependency
	docker compose exec app composer require $(package)

composer-require-dev: ## Add a new composer dependency as a dev dependency
	docker compose exec app composer require --dev $(package)

composer-remove: ## Remove a composer dependency
	docker compose exec app composer remove $(package)

composer-dump-autoload: ## Dump the autoloader
	docker compose exec app composer dump-autoload