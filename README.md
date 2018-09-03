# VONQ back-end assessment

Submission for **Aryel Tupinambá**

## Requirements:
- PHP 7.2
- Composer
- PHPUnit 7

## Stack used
- Symfony 4.1
- Doctrine 2
- SQLite for data persistence
- Fractal for API responses
- Several Symfony bundles 
- VueJS for the web client

## To install:
- Clone the repository
- Install the dependencies with composer
- Run the `doctrine:database:create` command
- Run the `doctrine:migrations:migrate` command
- Run the `doctrine:fixtures:load` command
- Run the `server:run` command
- The API will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000)
- The web client will be available at [http://127.0.0.1:8000/client](http://127.0.0.1:8000/client)
- To run the tests, run PHPUnit with the `phpunit.xml` config file
