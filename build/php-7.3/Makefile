.PHONY: prepare-php-7.3 test-php-7.3 test-suite-php-7.3

prepare-php-7.3: ## load dependencies with php 7.3
	docker-compose run -T php-7.3 /usr/bin/composer update

test-php-7.3: prepare-php-7.3 ## run tests against php 7.3
	docker-compose run -T php-7.3 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-7.3: prepare-php-7.3 ## run suite tests against php 7.3, ex: make test-suite-php-7.3 SUITE="unit"
	docker-compose run -T php-7.3 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)