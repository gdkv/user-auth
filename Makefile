up:
	docker-compose up

build:
	docker-compose build --pull php-pdo

destroy:
	docker-compose stop
	docker-compose rm -f

.PHONY: up build destroy