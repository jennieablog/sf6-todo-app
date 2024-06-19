# Symfony 6.4 Todo App

## Overview
Todo App is a basic To-Do List application where users can create, view, update, and delete tasks through a web interface.

This app was built using Symfony 6.4, PHP 8.1, HTML, and JavaScript. The Symfony 6.4 project is set up to run within a Docker environment, utilizing Docker Compose for managing multiple services. Docker containers are used to isolate the Symfony application, database (MySQL), and phpMyAdmin, a database administration tool.

## Requirements
- Docker
- Browser with enabled JavaScript
- Internet connection

## Functionality
1. View Todo List:
   - Navigate to / to view a list of all Todo items.
   - In the list page, Todo items can be completed and deleted without redirecting to another page.
   - Links for viewing and updating a Todo item are also available through the icons on the right-most side of each item.
   - Screenshot:<br><img src="https://github.com/jennieablog/sf6-todo-app/blob/main/screenshots/listing.png" width="300" />
2. Create a Todo:
   - Navigate to /todos/new to create a new Todo item.
   - Fill out the form and submit it to add a new Todo.
   - Screenshot:<br><img src="https://github.com/jennieablog/sf6-todo-app/blob/main/screenshots/new.png" width="300" />
3. Show a Todo:
   - To navigate to a Todo item's details page, click the first icon (eye) on the right-most side of the item, or navigate to /todos/{id} where {id} is the actual Todo ID.
   - The details page shall show the title, completed status, and description of the Todo item.
   - From this page, completing and restoring incomplete status is also possible without redirecting to another page.
   - Buttons for editing and deleting the Todo item are also available on this page.
   - Screenshot:<br><img src="https://github.com/jennieablog/sf6-todo-app/blob/main/screenshots/view.png" width="300" />
4. Update a Todo:
   - To navigate to a Todo item's edit page, click the second icon (pen) on the right-most side of the item, or navigate to /todos/{id}?isEditing=1 where {id} is the actual Todo ID.
   - The edit page shall have a form to allow updating of the title and description of the Todo item.
   - Screenshot:<br><img src="https://github.com/jennieablog/sf6-todo-app/blob/main/screenshots/edit.png" width="300" />
5. Complete a Todo:
   - To complete a Todo, just toggle the checkbox of the Todo item on the listing page.
   - It is also possible to delete a Todo by clicking the Complete button on the details page (see item 3).
   - Screenshot:<br><img src="https://github.com/jennieablog/sf6-todo-app/blob/main/screenshots/listing.png" width="300" />
   <br><img src="https://github.com/jennieablog/sf6-todo-app/blob/main/screenshots/view.png" width="300" />
6. Delete a Todo:
   - To delete a Todo, click the third icon (trash) on the right-most side of the item.
   - It is also possible to delete a Todo by clicking the Delete button on the details page (see item 3).
   - Screenshot:<br><img src="https://github.com/jennieablog/sf6-todo-app/blob/main/screenshots/delete.png" width="300" />

## Project Setup
1. Clone the project repository.
   ```bash
   git clone https://github.com/jennieablog/sf6-todo-app.git
   ```
2. Navigate to the project directory.
   ```bash
   cd sf6-todo-app/
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

To check and manage the databases for this project, the `phpMyAdmin` web interface may be accessed at `localhost:8080`. The server is `db`, `username` is `root`, and there is no password.
