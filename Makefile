# Composer

.PHONY: composer-install composer-update composer-install-dev composer-dump-auto
.SILENT: composer-install composer-update composer-install-dev composer-dump-auto

composer-install:
	docker run --rm \
	--volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
	--user $(id -u):$(id -g) \
	xediltd/composer install --ignore-platform-reqs --no-scripts ${DOWNLOAD_PROGRESS}
	rm -f auth.json

composer-update:
	docker run --rm --interactive --tty \
	--volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
	--user $(id -u):$(id -g) \
	xediltd/composer update --ignore-platform-reqs --no-scripts ${DOWNLOAD_PROGRESS}
	rm -f auth.json

composer-install-dev:
	docker run --rm --interactive --tty \
	-v $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
	--user $(id -u):$(id -g) \
	xediltd/composer install --ignore-platform-reqs --no-scripts --dev ${DOWNLOAD_PROGRESS}
	rm -f auth.json

composer-dump-auto:
	docker run --rm \
	--volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/app \
	--user $(id -u):$(id -g) \
	xediltd/composer dump-autoload
	rm -f auth.json

# Static Analysis

.PHONY: phpcs
.SILENT: phpcs

phpcs:
	docker run --rm --interactive --tty \
	--volume $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))):/web/html \
	--user $(id -u):$(id -g) \
	xediltd/pdk-phpcs:latest
