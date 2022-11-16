.PHONY: help build test

include $(CURDIR)/php-7.0/Makefile
include $(CURDIR)/php-7.1/Makefile
include $(CURDIR)/php-7.2/Makefile
include $(CURDIR)/php-7.3/Makefile
include $(CURDIR)/php-7.4/Makefile
include $(CURDIR)/php-8.0/Makefile
include $(CURDIR)/php-8.1/Makefile
include $(CURDIR)/php-8.2/Makefile

help:
	@grep -hE '^[a-zA-Z0-9_.-]+:.*?## .*$$' $(MAKEFILE_LIST) \
	| sort \
	| awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

build: ## build php images
	docker-compose build

test: ## test all against all php images
	$(MAKE) test-php-7.0
	$(MAKE) test-php-7.1
	$(MAKE) test-php-7.2
	$(MAKE) test-php-7.3
	$(MAKE) test-php-7.4
	$(MAKE) test-php-8.0
	$(MAKE) test-php-8.1
	$(MAKE) test-php-8.2

test-unit: ## test unit suite against all php images
	$(MAKE) test-suite-php-7.0 SUITE=unit
	$(MAKE) test-suite-php-7.1 SUITE=unit
	$(MAKE) test-suite-php-7.2 SUITE=unit
	$(MAKE) test-suite-php-7.3 SUITE=unit
	$(MAKE) test-suite-php-7.4 SUITE=unit
	$(MAKE) test-suite-php-8.0 SUITE=unit
	$(MAKE) test-suite-php-8.1 SUITE=unit
	$(MAKE) test-suite-php-8.2 SUITE=unit

.DEFAULT_GOAL := help
