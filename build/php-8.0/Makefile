.PHONY: prepare-php-8.0 test-php-8.0 test-suite-php-8.0

prepare-php-8.0: ## load dependencies with php 8.0
	docker compose run -T php-8.0 /usr/bin/composer update

test-php-8.0: prepare-php-8.0 ## run tests against php 8.0
	docker compose run -T php-8.0 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-8.0: prepare-php-8.0 ## run suite tests against php 8.0, ex: make test-suite-php-8.0 SUITE="unit"
	docker compose run -T php-8.0 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)