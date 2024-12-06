phpstan: ## Run the phpstan static analysis
	docker compose exec app ./vendor/bin/phpstan analyse src

phpcs: ## Run the phpcs code sniffer
	docker compose exec app ./vendor/bin/phpcs --standard=PSR12 src

phpcbf: ## Run the phpcbf code fixer
	docker compose exec app ./vendor/bin/phpcbf --standard=PSR12 src