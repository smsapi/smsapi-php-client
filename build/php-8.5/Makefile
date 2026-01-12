.PHONY: prepare-php-8.5 test-php-8.5 test-suite-php-8.5

prepare-php-8.5: ## load dependencies with php 8.5
	docker compose run -T php-8.5 /usr/bin/composer update

test-php-8.5: prepare-php-8.5 ## run tests against php 8.5
	docker compose run -T php-8.5 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml

test-suite-php-8.5: prepare-php-8.5 ## run suite tests against php 8.5, ex: make test-suite-php-8.5 SUITE="unit"
	docker compose run -T php-8.5 php vendor/bin/phpunit --configuration tests-resources/phpunit.xml --testsuite $(SUITE)