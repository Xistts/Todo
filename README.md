Установка
Шаг 1: Скопировать этот проект
```
 git clone https://github.com/Xistts/Todo.git
```

Шаг 2: Установить в проект composer.
```
composer install
```

Шаг 3: Создать базу данных и отредактировать файл .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE= Образец
DB_USERNAME=root
DB_PASSWORD=
```
Шаг 5: Запустить миграцию баз данных
```
php artisan migrate
```
Шаг 6: Запустить проект через open server
