# How to run application first time via docker.
1. Replace .env.example to .env.
2. Configure .env file.
3. Copy db data into ./tmp/db if you have it else skip this step.
4. Run `docker-compose up -d`.
5. Run `docker-compose exec app bash`.
6. Run `php artisan key:generate`.
7. *Skip this step if you do 3-rd step*
   1. Run `php artisan migrate`.
