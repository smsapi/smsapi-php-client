.PHONY: prepare-php-8.2 test-php-8.2 test-suite-php-8.2

prepare-php-8.2: ## load dependencies with php 8.2
	docker compose run -T php-8.2 /usr/bin/composer update

test-php-8.2: prepare-php-8.2 ## run tests against php 8.2
	docker compose run -T php-8.2 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-8.2: prepare-php-8.2 ## run suite tests against php 8.2, ex: make test-suite-php-8.2 SUITE="unit"
	docker compose run -T php-8.2 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)