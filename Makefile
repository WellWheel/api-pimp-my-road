PHP = $(shell which php)
COMPOSER = $(shell which composer)

.DEFAULT_GOAL := install

reinstall: clean/vendor clean/app/config/parameters.yml install

install: cc app/config/parameters.yml composer database

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


app/config/parameters.yml: | app/config/parameters.yml.dist
	echo " == Config =="
ifneq ($(HOST),) 
ifneq ($(DB_NAME),) 
ifneq ($(DB_USER),) 
ifneq ($(DB_PASSWD),)
	cp $(word 1,$|) $@
	$(call sed,HOST,${HOST},$@)
	$(call sed,DB_NAME,${DB_NAME},$@)
	$(call sed,DB_USER,${DB_USER},$@)
	$(call sed,DB_PASSWD,${DB_PASSWD},$@)
else
	$(error "DB_PASSWD not define ===> ")
endif
else
	$(error "DB_USER not define ===> ")
endif
else
	$(error "DB_NAME not define ===> ")
endif
else
	$(error "HOST not define ===> ")
endif

define sed
	sed -i 's/${1}/${2}/g' $3
endef

app/config/parameters.dist.yml:
	$(error "File $@ exist, it's on github !")

clean/%:
	rm -rf $*

