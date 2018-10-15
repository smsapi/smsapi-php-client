.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help

prepare: ## load dependencies
	docker-compose run -T php composer update --working-dir app --prefer-lowest

build: prepare ## build library
	docker-compose run -T php app/vendor/bin/phing -f app/build.xml build

test: prepare ## run test
	docker-compose run -T php app/vendor/bin/phing -f app/build.xml test
