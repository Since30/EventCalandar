# Symfony Task Management Application

![Symfony](https://img.shields.io/badge/Symfony-v5.3-green)
![Docker](https://img.shields.io/badge/Docker-20.10-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)

This project is a Symfony application for managing tasks with a calendar. It uses Docker to run a MySQL database and allows you to add users and tasks.

## Prerequisites

Make sure you have the following installed on your machine:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/download/)
- [Symfony CLI](https://symfony.com/download)

## Environment Setup

1. Clone this repository to your machine.

2. In the project directory, run the following command to start the MySQL database with Docker Compose:
   ```bash
   docker-compose up -d

3. install Symfony dependencies by running the following command:

bash
Copy code
composer install


4. Configure your database in the .env file by specifying your MySQL connection parameters.

.env.local

5. Create the database and run migrations to create the tables:

bash
Copy code
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

6. Running the Application
Start the Symfony server by running the following command:

bash
Copy code
symfony serve -d

7. Access the application in your browser by visiting http://localhost:8000.

Using the Application
Registration: To add a user, click on "Register" in the navigation menu and fill out the form.

Adding Tasks: To add a new task, click on "Add Task" in the navigation menu and fill out the form.

Calendar: The calendar displays all registered tasks. You can view different views (month, week, day) and click on a task to learn more.
