.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help

prepare: ## load dependencies
	docker run --rm -i -t -v '$(PWD)':/app composer:1.6.5 /usr/bin/composer update

build: prepare ## build library
	docker run --rm -t -v '$(PWD)':/app php:7-alpine php app/vendor/bin/phing -f app/build.xml build

test: prepare ## run test
	docker run --rm -t -v '$(PWD)':/app --network host php:7.0-alpine php app/vendor/bin/phing -f app/build.xml test

test-suite: prepare ## run test against suite, ex: make test-suite SUITE="unit"
	docker run --rm -t -v '$(PWD)':/app --network host php:7.0-alpine php app/vendor/bin/phing -f app/build.xml test -Dsuite=$(SUITE)