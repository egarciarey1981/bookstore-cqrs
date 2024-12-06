up: ## Start the docker containers
	docker compose up -d

down: ## Stop the docker containers
	docker compose down

restart: down up ## Restart the docker containers

logs: ## Show the logs of the containers
	docker compose logs -f