PHP = $(shell which php)
COMPOSER = $(shell which composer)

.PHONY: cc
cc: var/cache var/logs
	@echo " === Cache clear ===="
	rm -rf var/cache/* var/logs/*
	chmod 777 -R var/cache/ var/logs/
	@echo " === Clear symfony === "

var/cache:
	mkdir $@

var/logs:
	mkdir $@

database:
	$(PHP) bin/console doctrine:schema:update --force

composer:
	composer install

start: cc composer database

.DEFAULT_GOAL := start
