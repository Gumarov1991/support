docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose up --build -d

assets-install:
	docker-compose exec node yarn install

assets-rebuild:
	docker-compose exec node npm rebuild node-sass --force

assets-dev:
	docker-compose exec node yarn run dev

assets-watch:
	docker-compose exec node yarn run watch

perm:
	docker-compose exec php-cli chmod -R 777 /var/www/storage
	docker-compose exec php-cli chmod -R 777 /var/www/bootstrap/cache
	if [ -d "node_modules" ]; then sudo chown ${USER}:${USER} node_modules -R; fi
	if [ -d "public" ]; then sudo chown ${USER}:${USER} public -R; fi

symlink:
	docker-compose exec php-cli php artisan storage:link

project-setup:
	composer update
	docker-compose up --build -d
	docker-compose exec node yarn install
	docker-compose exec node yarn run dev
	docker-compose up -d
	sleep 10
	docker-compose exec php-cli php artisan migrate
	docker-compose exec php-cli php artisan storage:link
	docker-compose exec php-cli chmod -R 777 /var/www/storage
	docker-compose exec php-cli chmod -R 777 /var/www/bootstrap/cache
	if [ -d "node_modules" ]; then sudo chown ${USER}:${USER} node_modules -R; fi
	if [ -d "public" ]; then sudo chown ${USER}:${USER} public -R; fi
