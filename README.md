# Учебный проект с админ панелью

##Технологии
Laravel, Vue3, Inertia.js, TailwindCss

## Установка зависимостей
```
npm install
```
```
composer install
```
## Генерация ключа
Создать новую БД и файл .env по примеру .env.example.

Сгенерировать ключ
```
php artisan key:generate
```

## Миграции
Запустить миграцию и сидинг
```
php artisan migrate:fresh --seed
```

## Генерация ссылки на хранилище
```
php artisan storage:link
```

## Собрать frontend
```
npm run build
```

## Запустить локально сервер
```
php artisan serve
```



Посмотреть админ панель можно залогинившись как:
admin@admin.com
admin123
