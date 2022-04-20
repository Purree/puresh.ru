# How to run application first time via docker.
1. Replace .env.example to .env.
2. Configure .env file.
3. Copy db data into ./tmp/db if you have it else skip this step.
4. Run `docker-compose up -d`.
5. Run `docker-compose exec app bash`.
6. Run `php artisan key:generate`.
7. *Skip this step if you do 3-rd step*
   1. Run `php artisan migrate`.

# Certificates
- Install cert.:
1. Comment 443 server port in nginx.conf.
2. Run nginx.
3. `docker compose run --rm  certbot certonly --webroot --webroot-path /var/www/certbot/ -d puresh.ru`
4. Uncomment server and stop nginx
- Update cert.: <br/>
`docker compose run --rm certbot renew`
