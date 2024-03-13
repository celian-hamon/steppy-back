start:
	docker-compose up -d
stop:
	docker-compose down
install:
	cp .env.example .env
	docker-compose up -d
	docker exec -it steppy-back-laravel.test-1 composer install
	docker exec -it steppy-back-laravel.test-1 php artisan migrate:fresh
bash:
	docker exec -it steppy-back-laravel.test-1 bash
seed:
	docker exec -it steppy-back-laravel.test-1 php artisan db:seed
db-clean:
	docker exec -it steppy-back-laravel.test-1 php artisan migrate:fresh --seed
sync:
	docker exec -it steppy-back-laravel.test-1 php artisan app:sync-data
