.DEFAULT_GOAL := interactive

helper:
	# 'list of useful commands'
	@cat Makefile | egrep '^\w+'

interactive:
	@make $$(for x in $$(cat makefile | egrep '^\w+' | egrep -v '^.DEFAULT_GOAL|^SHELL|^PHPNY|^CLUSTER' | tr -d ':'); do printf "%s\n" $$x; done | peco)

exit:
	@echo 'good bye'

#######################
# S H E L L
# Need to set bash shell in order to use sourcing -> '.'
SHELL=/bin/bash

#######################
# D O C K E R
composer-install:
	docker run --rm -v $$(pwd):/app composer install

composer-install-ignore-reqs:
	docker run --rm -v $$(pwd):/app composer install --ignore-platform-reqs

build:
	docker-compose build
up:
	docker-compose up
upd:
	docker-compose up -d
down:
	docker-compose down
ps:
	docker-compose ps
logsf:
	docker-compose logs -f
tinker:
	docker-compose exec app php artisan tinker
repl: tinker
login:
	docker-compose exec app sh
route-list:
	docker-compose exec app php artisan route:list
config-cache:
	docker-compose exec app php artisan config:cache
composer-dumpautoload:
	docker-compose exec app composer dump-autoload
config-clear:
	# .envファイルの中身を書き換えた場合は
	docker-compose exec app php artisan config:clear
omajinai: composer-dumpautoload config-cache

up-without-volume:
	docker-compose -f docker-compose-without-volume.yml up

# D E B U G
up-debug:
	docker-compose -f docker-compose.yml -f docker-compose-override.yml up

build-debug:
	docker-compose -f docker-compose.yml -f docker-compose-override.yml build
