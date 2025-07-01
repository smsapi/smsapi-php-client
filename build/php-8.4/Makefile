.PHONY: prepare-php-8.4 test-php-8.4 test-suite-php-8.4

prepare-php-8.4: ## load dependencies with php 8.4
	docker-compose run -T php-8.4 /usr/bin/composer update --ignore-platform-req=PHP

test-php-8.4: prepare-php-8.4 ## run tests against php 8.4
	docker-compose run -T php-8.4 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-8.4: prepare-php-8.4 ## run suite tests against php 8.4, ex: make test-suite-php-8.4 SUITE="unit"
	docker-compose run -T php-8.4 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)