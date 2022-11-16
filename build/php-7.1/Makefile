.PHONY: prepare-php-7.1 test-php-7.1 test-suite-php-7.1

prepare-php-7.1: ## load dependencies with php 7.1
	docker-compose run -T php-7.1 /usr/bin/composer update

test-php-7.1: prepare-php-7.1 ## run tests against php 7.1
	docker-compose run -T php-7.1 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-7.1: prepare-php-7.1 ## run suite tests against php 7.1, ex: make test-suite-php-7.1 SUITE="unit"
	docker-compose run -T php-7.1 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)