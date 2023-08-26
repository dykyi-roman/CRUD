# CRUD

**Application:**
* Mapping Request Data to Typed Objects
* ADR pattern
* DDD tactical patterns
* Layered Architecture for code structure
* CI
* Functional tests

### How to Install locally

1) Execute command: `make install`

## Folder structure
* backend - backend code base
* infrastructure:
  * containers - docker containers
  * data - temporary resource folder
  * env: 
    * prod - docker compose and env
    * stage - docker compose and env
    * local - docker compose and env
  * postman - postman collections and env

# Backend

API: [https://localhost:8080/](https://localhost:8080/)

### Available ENV parameters

| Parameter name             | Description            | Example                                            |
|----------------------------|------------------------|----------------------------------------------------|
| DATABASE_URL               | Database dsn           | mysql://db_user:db_password@127.0.0.1:3306/db_name | 

## API Documentation

In browser: [https://localhost:8080/api/doc](https://localhost:8080/api/doc)

## phpMyAdmin

In browser: [http://localhost:8184](http://localhost:8184)

### Infrastructure
* Symfony 6.3
* PHP 8.2
* Mariadb 10.7
* Nginx stable-alpine

### CI

Execute command: `make ci` 

<b>PHP CS Fixer</b> - `make backend-phpcs`

<b>PHPStan</b> - PHPStan scans your whole codebase and looks for both obvious & tricky bugs. Execute the command: `make backend-phpstan`

<b>Psalm</b> - Psalm is a static analysis tool for finding errors in PHP applications. Execute the command: `make backend-psalm`

<b>Deptrac</b> - Deptrac is a static code analysis tool for PHP that helps you communicate, visualize and enforce architectural decisions in your projects. Execute the command: `make backend-deptrac`

<b>Newman</b> - Newman is a command-line collection runner for Postman. It allows you to effortlessly run and test a Postman collection. Execute the command: `make test-postman`

<b>Tests</b> - Unit testing is testing the smallest testable unit of an application. Execute command: `make backend-test-run`
