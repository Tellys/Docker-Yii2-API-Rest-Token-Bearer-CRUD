<p align="center">
 <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
         <img src="https://www.docker.com/wp-content/uploads/2023/08/logo-guide-logos-1.svg" height="100px">
    <h1 align="center">Docker Yii2 API Rest, Token Bearer, CRUD</h1>
    <br>
</p>

The application uses Docker to create the execution environment and the template has the following technologies:
- Apache Http Server
- Mysql database
- PHP language (Yii PHP Framework - version Yii2)

RESTful APIs usando a performance CRUD com operadores usando os métodos HTTP: POST, GET, PUT, and DELETE.

INSTALLATION
------------

### Install 

Following command:

~~~
git clone https://github.com/Tellys/Docker-Yii2-API-Rest-Token-Bearer-CRUD
~~~

Enter into folder 

~~~
cd yii2-desafio
~~~

Docker command

~~~
docker compose pull && docker compose build && docker compose up -d
~~~

Set permissions folders

~~~
docker exec -it php_apache bash

chmod 777 assets
chmod 777 web/assets
chmod 777 runtime
~~~

Install packages compose

~~~
composer install
~~~

Install DB migrations

~~~
php yii migrate/up
~~~

## How to use

#### API
~~~
http://localhost:8000/
~~~

#### PhpMYAdmin
~~~
http://localhost:8081/
~~~

#### Adminer
~~~
http://localhost:8082/
~~~

##  Postman Collections API end points

All system **urls end points** and their variables are already formatted in our public **Postman** collection, at the link below
~~~
https://www.postman.com/restless-shuttle-935092/workspace/yii2-api-rest-token-bearer-crud/collection/20718206-d82b9fd0-1cc7-4fe5-94f2-c80cf9c82464?action=share&creator=20718206
~~~

##  Maintainer
~~~
Tellys Castro
https://github.com/Tellys
~~~
    
