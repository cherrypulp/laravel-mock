# Mock

[![Build Status](https://travis-ci.org/cherrypulp/laravel-mock.svg?branch=master)](https://travis-ci.org/cherrypulp/laravel-mock)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cherrypulp/laravel-mock/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cherrypulp/laravel-mock/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/CHANGEME/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/cherrypulp/laravel-mock/badge.svg?branch=master)](https://coveralls.io/github/cherrypulp/laravel-mock?branch=master)

[![Packagist](https://img.shields.io/packagist/v/cherrypulp/laravel-mock.svg)](https://packagist.org/packages/cherrypulp/laravel-mock)
[![Packagist](https://poser.pugx.org/cherrypulp/laravel-mock/d/total.svg)](https://packagist.org/packages/cherrypulp/laravel-mock)
[![Packagist](https://img.shields.io/packagist/l/cherrypulp/laravel-mock.svg)](https://packagist.org/packages/cherrypulp/laravel-mock)

An simple mock api helper that simulate GET, PUT, DELETE, POST requests and store it to a json folder.

## Installation

Install via composer
```bash
composer require blok/laravel-mock
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
Blok\Mock\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
Blok\Mock\Facades\Mock::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="Blok\Mock\ServiceProvider" --tag="config"
```

## Usage

Let's say that you have this in your mock folder

```
mock
|- users
|-- 1.json
|-- 2.json
```

If you make that requests : 

GET /mock/users will return : 

````json
[
  {
    "1" : {
      "id" : 1,
      "name" : "foo"
    }
  },
  {
    "2" : {
      "id" : 2,
      "name" : "bar"
    }
  }
]
````

GET /mock/users/1 will return : 

````json
{
      "id" : 1,
      "name" : "foo"
}
````

PUT /mock/users/1 will save your request into /mock/users/1.json

DELETE /mock/users/1 will delete your request in /mock/users/1.json

That's it!

## Security

If you discover any security related issues, please email me
instead of using the issue tracker.

## Credits

- [](https://github.com/cherrypulp/laravel-mock)
- [All contributors](https://github.com/cherrypulp/laravel-mock/graphs/contributors)

This package is bootstrapped with the help of
[blok/laravel-package-generator](https://github.com/cherrypulp/laravel-package-generator).
