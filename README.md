# Mock

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cherrypulp/laravel-mock/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cherrypulp/laravel-mock/?branch=master)
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

### Folder mode

Let's say that you have this in your mock folder

```
storage/mock
|- users
|-- 1.json
|-- 2.json
```

If you make that requests : 

GET /mock/users it will return : 

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

### Factory mode

If you see the config/mock.php you will see a commented array in entrypoints.

If you uncommented that you will be able to call your factory for the model you want.

=> if enabled it will return mock data from your factories instead from json.

### Test a FormRequest or mock a validation

You can easily test your FormRequest or Validation by adding in the entrypoint "$action$_validation" in your config file => it could receive an array or a FormRequest.

### Force to json

By default, the config will only accept json request, but if you want for some reason disable or test a redirection instead. You can do it in your config file (at a global or in the method level of the controller).

## Security

If you discover any security related issues, please email me
instead of using the issue tracker.

## Credits

- [Daniel Sum](https://github.com/cherrypulp/laravel-mock)
- [All contributors](https://github.com/cherrypulp/laravel-mock/graphs/contributors)

This package is bootstrapped with the help of
[blok/laravel-package-generator](https://github.com/cherrypulp/laravel-package-generator).
