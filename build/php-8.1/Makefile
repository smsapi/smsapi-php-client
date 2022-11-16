.PHONY: prepare-php-8.1 test-php-8.1 test-suite-php-8.1

prepare-php-8.1: ## load dependencies with php 8.1
	docker-compose run -T php-8.1 /usr/bin/composer update

test-php-8.1: prepare-php-8.1 ## run tests against php 8.1
	docker-compose run -T php-8.1 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-8.1: prepare-php-8.1 ## run suite tests against php 8.1, ex: make test-suite-php-8.1 SUITE="unit"
	docker-compose run -T php-8.1 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)