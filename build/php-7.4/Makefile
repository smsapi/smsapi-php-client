.PHONY: prepare-php-7.4 test-php-7.4 test-suite-php-7.4

prepare-php-7.4: ## load dependencies with php 7.4
	docker-compose run -T php-7.4 /usr/bin/composer update

test-php-7.4: prepare-php-7.4 ## run tests against php 7.4
	docker-compose run -T php-7.4 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-7.4: prepare-php-7.4 ## run suite tests against php 7.4, ex: make test-suite-php-7.4 SUITE="unit"
	docker-compose run -T php-7.4 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)