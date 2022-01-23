## Project Installation Instructions

1. Clone Project using `git clone https://github.com/ckpanchal/sf44test.git` command.

2. Run `composer install` command to install all project dependencies.

3. Add database server credentials in `.env` file.

4. Run `php bin/console doctrine:database:create` command to create database.

5. Run `php bin/console doctrine:schema:update --force` command to create tables in database.

6. For Broswer User, Run `symfony server:start --d` command to run server and redirect to `http://127.0.0.1:8000` to view colleague list

7. For CLI User, Run `php bin/console app:create-colleague` command to add new colleague

## Test Cases

1. Run `php bin/console doctrine:schema:update --force --env=test` command to create test database

2. Run `php ./vendor/bin/phpunit` command to run test
