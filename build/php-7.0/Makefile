.PHONY: prepare-php-7.0 test-php-7.0 test-suite-php-7.0

prepare-php-7.0: ## load dependencies with php 7.0
	docker-compose run -T php-7.0 /usr/bin/composer update

test-php-7.0: prepare-php-7.0 ## run tests against php 7.0
	docker-compose run -T php-7.0 php vendor/bin/phpunit --configuration phpunit.xml

test-suite-php-7.0: prepare-php-7.0 ## run suite tests against php 7.0, ex: make test-suite-php-7.0 SUITE="unit"
	docker-compose run -T php-7.0 php vendor/bin/phpunit --configuration phpunit.xml --testsuite $(SUITE)