# employee-app

## Project Requirement

- PHP : PHP 8.1 Or Higher versions,
- MySQL : 6.0 Or newer versions
- Server : Apache2 Or Nginx Server

## Installation

Install the dependencies and start the server.

##### Clone repositery

```sh
git clone https://github.com/aakashdesai-pro/employee-app.git
```

##### Go to project directory
```sh
cd employee-app
```

##### Install PHP dependencies
```sh
composer install
```

##### Create .env file and Copy .env.example file content to .env file
```sh
cp .env.example .env
```

##### Run migrations and seeders
```sh
php artisan migrate
```

##### Run project
```sh
php artisan serve --port=8000
```

##### Main files
```sh
routes\web.php
app\Http\Controllers\EmployeeController.php
```

#### Screenshots
![alt text](https://i.ibb.co/ryR3kzz/Screenshot-2023-12-28-133554.png)
![alt text](https://i.ibb.co/XC8VNvT/Screenshot-2023-12-28-133922.png)
![alt text](https://i.ibb.co/RQRRHSL/Screenshot-2023-12-28-134001.png)

##### References sites
- [Laravel](https://laravel.com/docs/10.x)