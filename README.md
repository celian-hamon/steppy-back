# SETUP

### Linux / Mac :
- `make install`

### Windows :
- cloner le fichier `.env.example` et le renommer en `.env`
- faire un composer install
- lancer `docker compose up -d`
- rentrer dans le docker `docker exec -it steppy-back-laravel.test-1 bash`
- lancer `php artisan migrate:fresh` (ajouter ``--seed`` si besoin)


