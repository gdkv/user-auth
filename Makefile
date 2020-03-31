up:
	docker-compose up
	chmod 777 ./app/public/uploads

build:
	docker-compose build --pull php-pdo

destroy:
	docker-compose stop
	docker-compose rm -f

.PHONY: up build destroy