all: style static test


style:
	docker-compose exec curl-printer vendor/bin/php-cs-fixer fix

static:
	docker-compose exec curl-printer vendor/bin/phpstan analyze src -c phpstan.neon

test:
	docker-compose exec curl-printer vendor/bin/phpunit tests --colors

composer:
	docker-compose exec curl-printer composer install


