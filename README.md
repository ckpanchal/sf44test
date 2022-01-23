## Project Installation Instructions

1. Clone Project using `git clone https://github.com/ckpanchal/sf44test.git` command.

2. Run `composer install` command to install all project dependencies.

3. Create MySQL database and add configuration in `.env`

4. For Broswer User, Run `symfony server:start --d` command to run server and redirect to `http://127.0.0.1:8000` to view colleague list

5. For CLI User, Run `php bin/console app:create-colleague` command to add new colleague

## Test Cases

1. Run `php bin/console doctrine:schema:update --force --env=test` command to create test database

2. Run `php ./vendor/bin/phpunit` command to run test
