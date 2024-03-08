
<h1 align="center">Symfony 6.3 - Mysql - Docker - Hexagonal Architecture</h1> 

### 🐳 Docker + PHP 8.2 + MySQL + Nginx + Symfony 6.3

## Description

This is a complete stack for running Symfony 6.3 into Docker containers using docker compose tool.

It is composed by 4 containers:

- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 8.2 version of PHP.
- `db` which is the MySQL database container with a **MySQL 8.0** image.
- `phpmyadmin` is a free software tool written in PHP, intended to handle the administration of MySQL over the Web.

### :heavy_check_mark: Features

<li>User management (Registration, cancellation, Modification)</li>
<li>User Group Management (Registration, Cancellation, Modification)</li>
<li>User search engine with pagination</li>
<li>Migration command</li>
<li>Factory creation command </li>

### :heavy_check_mark:	Docker

- <code>docker compose build</code>
- <code>docker compose up -d</code>

### :heavy_check_mark:	Facilities (Optionals)

- <code>php bin/console doctrine:migrations:migrate</code>

- <code>php bin/console app:create-entities</code>

<p>Optional Command </p>

- <code>php bin/console app:create-group</code>
- <code>php bin/console app:create-user</code>
- <code>bin/phpunit --testdox</code>


### :rocket: Technologies Used

##### :heart: Built With:

* ![Docker](https://img.shields.io/badge/Docker-<COLOR>?style=for-the-badge&logo=docker&logoColor=white) [Docker](https://www.docker.com/)
* ![Symfony 6.3](https://img.shields.io/badge/Symfony-<COLOR>?style=for-the-badge&logo=Symfony&logoColor=white) [Symfony](https://Symfony.com/)
* ![Mysql](https://img.shields.io/badge/Mysql-<COLOR>?style=for-the-badge&logo=mysql&logoColor=white) [Mysql](https://www.mysql.com/)

### :heavy_check_mark: Images:

![Test](/test.png)