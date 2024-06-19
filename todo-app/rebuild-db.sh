#!/bin/bash

# Instantiates the dev db
php bin/console doctrine:database:drop -n --if-exists --force \
	&& php bin/console doctrine:database:create -n \
    && php bin/console doctrine:schema:create -n
