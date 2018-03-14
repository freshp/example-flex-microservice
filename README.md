# test microservice flex project

this package provides all basic features of a micro service in php.

Features:
* default configuration of docrtine orm inclusive fixture handling (doctrine/dbal, doctrine/orm, doctrine/common)
* api documentation (nelmio/api-doc-bundle)
  * route `/api/doc`
* softdelete (stof/doctrine-extensions-bundle)
* log all entity changes (stof/doctrine-extensions-bundle)
* timestamps for create and update entities (stof/doctrine-extensions-bundle)
* save user for create and update entities (stof/doctrine-extensions-bundle)
* edge to edge webtestcase for routes with fixtures (freshp/phpunit-webtestcase-fixture-helper)
* possibility to log all service requests by using sentry (sentry/sentry-symfony)
* locally working with symfony webserver and sqlite
* garbage collector for old softdeleted entries
  * console command to hard delete entries by parameter 

### build local environment
1. create database
    ```
    php ./bin/console doctrine:database:create
    ```
2. built schema
    ```
    php ./bin/console doctrine:schema:update --force
    ```
3. run the php built in server
    ```
    php ./bin/console server:start 127.0.0.1:8000
    ```

## Checks
Run each command in the project root directory.

### Execute PHPUnit tests
```
./vendor/bin/phpunit.phar -c ./phpunit.xml --debug --verbose
```

### Execute PHPMD checks
```
./vendor/bin/phpmd.phar ./src text ./phpmd.xml
```

### Execute PHPCS checks
```
./vendor/bin/phpcs.phar ./src --standard=PSR2
```

### Execute PHPCPD checks
```
./vendor/bin/phpcpd.phar ./src
```

### Execute PHPSTAN checks
```
./vendor/bin/phpstan.phar analyse -l 7 src/
```
