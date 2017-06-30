# Synopsis
Creating and consuming REST API using Slim Micro framework (v3) for PHP and MySQL database.
https://www.slimframework.com/

## Getting Started
Clone this project (git clone) on your localhost in root directory or download and unzip the folder

### Prerequisites
Minimum PHP version - 5.6
Please install the composer - A Dependency Manager for PHP using below link:
https://getcomposer.org/download/

### Installing
* Create new database called restapi on your mysql database
* Import restapi.sql or open the file and execute the script on your database
* Navigate to your folder /rest-api-php and run below command
    `composer install` (this command will install all the dependencies required for your project to run properly)
* Edit /rest-api-php/config/config.php and add DB credentials and other details
* Edit /rest-api-php/examples/config/config.php change API_URL as per your localhost URL
* Edit .htaccess file as per your requirements

## Running the tests
Navigate to http://localhost/rest-api-php

### Code Example
```php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    
    require_once '/vendor/autoload.php';
    require_once 'config/config.php';
    
    // create new instance of Slim application
    $app = new \Slim\App;
    // To get access token
    $app->get('/api/v1/token/{loginid}', 'getToken');
    // list user by id / list all users
    $app->get('/api/v1/user[/{id}]', 'getUsers')->add('authenticate');
    // add new user
    $app->post('/api/v1/user/create', 'createUser')->add('authenticate');
    // update existing user
    $app->put('/api/v1/user/update/{id}', 'updateUser')->add('authenticate');
    // delete existing user
    $app->delete('/api/v1/user/delete/{id}', 'deleteUser')->add('authenticate');
    // run the application
    $app->run();
```
    getToken, getUsers, createUser,updateUser,deleteUser are all functions.

    Please find the detail information for each functions inside the /rest-api-php/api.php

## Deployment
To deploy on live server clone this project using git clone or download, unzip and upload the files on server. Follow the [installing](#installing) instruction as shown above.

## Motivation
This project will help you to get start with REST API in a simple way

