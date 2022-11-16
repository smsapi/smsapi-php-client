.PHONY: prepare-php-7.2 test-php-7.2 test-suite-php-7.2

prepare-php-7.2: ## load dependencies with php 7.2
	docker-compose run -T php-7.2 /usr/bin/composer update

test-php-7.2: prepare-php-7.2 ## run tests against php 7.2
	docker-compose run -T php-7.2 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-7.2: prepare-php-7.2 ## run suite tests against php 7.2, ex: make test-suite-php-7.2 SUITE="unit"
	docker-compose run -T php-7.2 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)