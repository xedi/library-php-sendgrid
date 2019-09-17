# Composer

.PHONY: composer-install
.SILENT: composer-install

composer-install:
	docker run --rm \
	--volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
	--user $(id -u):$(id -g) \
	xediltd/composer install --ignore-platform-reqs --no-scripts --no-progress
	rm -f auth.json

# Static Analysis

.PHONY: phpcs
.SILENT: phpcs

phpcs:
	docker run --rm --interactive --tty \
	--volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/web/html \
	--user $(id -u):$(id -g) \
	xediltd/pdk-phpcs:ci-latest