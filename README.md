1. Миграция
`php artisan migrate`
2. Для запуска генерации базы данных пишем команду:
`php artisan db:seed --class=UsersTableSeeder`
***
task 3.0
---
* генерация DatabaseSeederUserGroup 15 шт
`php artisan db:seed --class=DatabaseSeederUserGroup`
* генерация DatabaseSeederUserGroups 25 шт
`php artisan db:seed --class=DatabaseSeederUserGroups`

task 4.0
---
* добавлены колонки
* сделан первый роут
* генерация UserApi 15 шт
 `php artisan db:seed --class=UserApi`

task 4.1
--- 
* Исправлена ошибка в первом роуте
* update migration
 
task4.2
---
* добавлен 3-4 роут
* исправлены ошибки

task 5.1
---
* добавлен второй роут

task 5.2
---
* добавлен 3 роут
* task5.3
* исправленны ошибки
*добавлен 4 роут

task 6.0
---
* done

task 7.0
---
* создали миграцию php artisan queue:table
* создали 3 класса php artisan make:mail
* creating Jobs php artisan make:job
* done
* исправлены ошибки Task4

task 8.0
---
Сделаны тесты для task3
```
//чистим базу и накатываем все миграции
.\vendor\bin\phpunit ./tests/Feature/ClearBase.php
.\vendor\bin\phpunit ./tests/Feature/Http/Controllers/UserControllerTests.php
.\vendor\bin\phpunit --configuration phpunit.xml
.\vendor\bin\phpunit ./tests/Feature/Http/Controllers/AuthControllerTests.php
```
task 8.1
---
* исправлены ошибки в task5
* добавлены тесты ддя task4
* добавлен Swagger

