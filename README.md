1. Миграция
`php artisan migrate`
2. Для запуска генерации базы данных пишем команду:
`php artisan db:seed --class=UsersTableSeeder`

task3
генерация DatabaseSeederUserGroup 15 шт
`php artisan db:seed --class=DatabaseSeederUserGroup`
генерация DatabaseSeederUserGroups 25 шт
`php artisan db:seed --class=DatabaseSeederUserGroups`

$task4.0
-добавлены колонки
-сделан первый роут
-генерация UserApi 15 шт
 `php artisan db:seed --class=UserApi`
 task4.1
-Исправлена ошибка в первом роуте
+update migration 
task4.2
-добавлен 3-4 роут
-исправлены ошибки
task5.1
-добавлен второй роут
-task5.2
-добавлен 3 роут
-task5.3
-исправленны ошибки
-добавлен 4 роут
-task6
-done
-task7
-создали миграцию php artisan queue:table
-создали 3 класса php artisan make:mail
-Creating Jobs php artisan make:job
-done
-исправлены ошибки Task4