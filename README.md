# Bank Transactions. The initial setup for banking system on Laravel.

##Live Demo
Check the demo version on this link bellow: <br>
<a href="http://bank-transactions.jovetrajkoski.com">Demo</a>

## Introduction
Backend Developer Test Task

**Dependency** <br>
- PHP 7.0
- MYSQL 5.7

## Installation
- Clone repository
```
$ git clone https://github.com/GitJove/BankTransactions.git
```
- Run in your terminal
```
$ composer install
$ php artisan key:generate

## Setup
```
- Setup database connection in .env file ( Change .env.example file to .env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pspmedia
DB_USERNAME=homestead
DB_PASSWORD=secret
```

- Install node package manager NPM
```
$ npm install
```
- Migrate tables with demo data
```
$ php artisan migrate:fresh --seed
```

- Laravel 5 Files Folders Permission and Ownership Setup
```
$ cd /dir/of/laravel
$ chmod -R 777 ./storage ./bootstrap

You may need to use sudo on these commands if you get permission denied errors, i.e.:
$ sudo cd /path/to/banktransaction
$ sudo chmod -R 777 ./storage ./bootstrap

For more info:
https://www.itechempires.com/2017/06/laravel-5-files-folders-permission-ownership-setup/
```
For more info about Laravel framework:
https://laravel.com/docs/5.5

- Access it on
```
http://your-local-domain/
```
API Reporting
``` 
http://your-local-domain/api/report
```
WEB routes
``` 
http://your-local-domain/login
http://your-local-domain/register
http://your-local-domain/report
```
Auth routes home
``` 
http://your-local-domain/transactions
```
## Known Issues
- No issies are detected.. We are comming to Malta (#fingerscrossed)

## Roadmap for v1.0
- Database migration schema (users table, countries table, transactions table etc.)
- Creating models (User, Continent, Country, City, Transaction)
- SOLID principles (Design Patterns)
- Laravel Custom Logger (app/Utilities/CustomLogger)) 
- Business Logic layer(app\Services\)
- Whip Monstrous Code Into Shape: Scopes, Repositories, Query Objects
- Laravel 5 Repositories is used to abstract the data layer, making our application more flexible to maintain ( https://github.com/andersao/l5-repository )
<img src="http://esbenp.github.io/img/service-repository-pattern-2.png" alt="">  <br> 
- Making WeeklyReportService (implementing some ReportService interface) for the business logic or business layer of the application
- Implementing Pessimistic vs Optimistic Locking ( https://medium.com/snapptech/pessimistic-vs-optimistic-locking-in-laravel-264ec0b1ba2 )
- Tests (Feature test - UpdateUserInSameTimeTest folder(tests/Feature), Unit test - MakeTransactionTest folder(tests/Feature))
- Database Factory pattern for seeders (UsersSeeder, CountrySeeder, TransactionsSeeder etc..)
- barryvdh/laravel-debugbar to manage and test all queries
- For more complex design oriented approach follow this example: ( http://esbenp.github.io/2016/04/11/modern-rest-api-laravel-part-1/ )
- Cool ideas from pspmedia developers :)

## ER Diagram
![alt_text](https://i.imgur.com/isNQq8h.png "ERD")

## Screenshots
![alt text](https://i.imgur.com/vi8UnNh.png "Transactions")
![alt text](https://i.imgur.com/1Bay5Zu.png "Transactions")
![alt text](https://i.imgur.com/StR6rU0.png "Transactions")
![alt text](https://i.imgur.com/bqJH07H.png "Transactions")
![alt text](https://i.imgur.com/2o99uui.png "Transactions")
