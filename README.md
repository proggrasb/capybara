# General
- Based on Alpine Linux.
- Symfony 6.2
- PostgreSQL
- Doctrine

## Run application

1) Build containers: `docker-compose up -d --build`
2) For the first time setup:
    * go into container: `docker-compose exec php bash` or `docker exec -it capybara-php bash`
    * execute setup script: `./setup.sh`
3) When you have finished performing commands the application should be available on the URL address:
    * `http://localhost:9090`
