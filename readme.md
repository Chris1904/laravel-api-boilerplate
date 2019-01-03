## Laravel 5.7 - API Boilerplate

This is on opinionated API built on top of the Laravel Framework.

It is built on top of these packages:

* JWT Auth - [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
* Dingo API - [dingo/api](https://github.com/dingo/api)
* Laravel-CORS [barryvdh/laravel-cors](http://github.com/barryvdh/laravel-cors)
* Activity Log [spatie/laravel-activitylog](http://github.com/spatie/laravel-activitylog)
* Backup [spatie/laravel-backup](http://github.com/spatie/laravel-backup)
* Permission [spatie/laravel-permission](http://github.com/spatie/laravel-permission)

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan jwt:secret
```

## Get Started

wip

## Inspiration

This package was inspired by [francescomalatesta/laravel-api-boilerplate-jwt](http://github.com/francescomalatesta/laravel-api-boilerplate-jwt)

## Postman

This is a [Postman](https://www.google.com) routes collection to test the API boilerplate. Feel free to extend it.
