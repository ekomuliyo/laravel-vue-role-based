## laravel-vue-role-based-todo

A simple laravel vue application that has user rules Admin and Users, that build used Laravel 6 and Vue.js 2

#### user testing
1. admin@test.com
2. uset@test.com
password: secret

### setup project

```
$ cp .env.example .env 
$ npm install
$ composer install
```

### setup environment
open file .env
```env
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USERNAME
DB_PASSWORD=YOUR_DATABASE_PASSWORD
```

### run project
```
$ php artisan migrate --seed
$ npm run watch
$ php artisan serve
```


#### Source Tutorial

[Create a SPA with role-based authentication with Laravel and Vue.js](https://medium.com/@ripoche.b/create-a-spa-with-role-based-authentication-with-laravel-and-vue-js-ac4b260b882f)
