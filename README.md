## Nixope Task



## Features:
1. Docker containers for 3 services (NGINX, php, and Mysql)

1. Users
  1.1 create a new user with *username*, *email* required, and optionally attach one or more roles.
  1.2 update a user data.
  1.3 soft delete the user.
  1.4 paginate among users in the database.
  1.5 show a specific user resource.

1. Dispatch event to generate an activation link and send it via email.
    > listener would append the info to the log file

1. Automated test cases to cover most of the scenarios in the code.



## Installation:
1. install docker and docker-compose
1. ```git clone https://github.com/ahmedmohamed24/nixope.git```
2. ``` cd nixope ```
1. set environment variables for docker-compose
  ```vim .env```
    ```
    DATABASE_NAME=nixope
    DATABASE_USER=root
    DATABASE_PASSWORD=verystrongpassword
    DATABASE_ROOT_PASSWORD=verystrongpassword
    ```
3. ``` docker-compose up -d --build```
4. run test cases ```docker exec -it php php artisan test```
1. ```cd src && cp .env.example .env```
1. set laravel database environment variables in `./src/.env`:
    ```
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=nixope
    DB_USERNAME=root
    DB_PASSWORD=verystrongpassword
    QUEUE_CONNECTION=database
    ```
5. import the postman collection `./postman.json`, and start using it