#!/bin/bash

# Run php-cs-fixer and clear cache
php vendor/bin/php-cs-fixer fix \
    && php bin/console cache:clear --env=test

# Instantiates the test db
php bin/console doctrine:database:drop -n --if-exists --force --env=test \
	&& php bin/console doctrine:database:create -n --env=test \
    && php bin/console doctrine:schema:create -n --env=test

# Validate the schema
php bin/console doctrine:schema:validate --env=test

# Run unit tests
php bin/phpunit
