# Symfony 6.4 Todo App

## About
Todo App is a basic To-Do List application where users can create, view, update, and delete tasks through a web interface.

This app was built using Symfony 6.4 and PHP 8.1. The Symfony 6.4 project is set up to run within a Docker environment, utilizing Docker Compose for managing multiple services. Docker containers are used to isolate the Symfony application, database (MySQL), and phpMyAdmin, a database administration tool.

## Requirements
- Docker
- Browser with enabled JavaScript
- Internet connection

## Project Setup
1. Clone the project repository.
   ```bash
   git clone https://github.com/jennieablog/sf6-todo-app.git .
   ```
2. Navigate to the project directory.
   ```bash
   cd todo-app/
   ```
3. Run the following command to build the Docker images and start containers for services defined in the docker-compose.yml file.
   ```bash
   docker-compose up -d --build
   ```
4. Navigate to the Symfony project folder, and the enable execution of the dev scripts for setting up the database and performing unit tests.
   ```bash
   cd todo-app/ && chmod +x docker-exec *.sh
   ```
5. Initialize the environment variables in `.env` by copying the already-populated .env.sample file
   ```bash
   cp .env.sample .env
   ```
6. Run the following to run composer install within the Docker container to install all project dependencies.
   ```bash
   ./docker-exec composer install
   ```
7.  Run the `rebuild-db.sh` script to create the database and schema.
   ```bash
   ./docker-exec ./rebuild-db.sh
   ```
8.  Verify that the app can be accessed at `todo-app.localhost:8741`.

## Testing
Run the test script to peform tests on the Todo App:
```bash
   ./docker-exec ./test.sh
```
The above test script runs the following in order:
   - `php vendor/bin/php-cs-fixer fix` to automatically fix PHP coding standards issues in the code.
   - `php bin/console cache:clear --env=test` to remove previously cached data, forcing Symfony to regenerate it as needed.
   - `php bin/console doctrine:schema:validate` to validate the Doctrine ORM (Object-Relational Mapping) schema against the database.
   - `php bin/phpunit` to ensure that the following functionalities are implemented within the controller methods:
     - Users should be able to create a new task with a title and description.
     - Users should be able to view a list of all tasks.
     - Users should be able to edit an existing task.
     - Users should be able to delete a task.
