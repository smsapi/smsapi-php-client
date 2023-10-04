.PHONY: prepare-php-8.3 test-php-8.3 test-suite-php-8.3

prepare-php-8.3: ## load dependencies with php 8.3
	docker-compose run -T php-8.3 /usr/bin/composer update --ignore-platform-req=PHP

test-php-8.3: prepare-php-8.3 ## run tests against php 8.3
	docker-compose run -T php-8.3 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-8.3: prepare-php-8.3 ## run suite tests against php 8.3, ex: make test-suite-php-8.3 SUITE="unit"
	docker-compose run -T php-8.3 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)