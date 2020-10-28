.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help

prepare: ## load dependencies
	docker-compose run -T php /usr/bin/composer update
	docker-compose run -T php /usr/bin/composer require --dev guzzlehttp/guzzle

test: prepare ## run test
	docker-compose run -T php php vendor/bin/phing -f build.xml test

test-suite: prepare ## run test against suite, ex: make test-suite SUITE="unit"
	docker-compose run -T php php vendor/bin/phing -f build.xml test -Dsuite=$(SUITE)