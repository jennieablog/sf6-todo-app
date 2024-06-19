# Symfony 6.4 Todo App

## About
This Todo app is a basic To-Do List application where users can create, view, update, and delete tasks through a web interface. It was build using Symfony 6.4 and PHP 8.1.

## Requirements
- Docker / Docker desktop
- Browser with enabled JavaScript
- Internet connection

## Project Setup
1. Clone repository and `cd` into the folder `cd todo-app/`
2. Run `docker-compose up -d --build` in the terminal.
3. Run the following to enable scripts: `cd todo-app/ && chmod +x docker-exec *.sh`
4. Copy the env file `cp .env.sample .env` and set `DATABASE_URL="mysql://root:@db:3306/todo-app_db"` in `.env`.
5. Run `./docker-exec composer install`
6. Run the following to instantiate the database: `./docker-exec ./rebuild-db.sh`
7. The app can now be accessed at `todo-app.localhost:8741`.

## Testing
1. Run the following to instantiate the test database: `./docker-exec ./test.sh`
2. Run `php bin/phpunit` to run the unit tests for the application. This should ensure that the following functionalities are implemented:
   - Users should be able to create a new task with a title and description.
   - Users should be able to view a list of all tasks.
   - Users should be able to edit an existing task.
   - Users should be able to delete a task.
