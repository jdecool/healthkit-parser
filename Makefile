.PHONY: tests

help: ## Display this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

lint: ## Run PHP linter
	@if find {app,cli,tests} -name "*.php" -exec php -l {} 2>&1 \; | grep "syntax error, unexpected"; then exit 1; fi

tests: ## Run PHPUnit tests
	composer install && vendor/bin/phpunit
