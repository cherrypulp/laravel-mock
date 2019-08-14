# Mock

[![Build Status](https://travis-ci.org/blok/mock.svg?branch=master)](https://travis-ci.org/blok/mock)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/blok/mock/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/blok/mock/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/CHANGEME/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/blok/mock/badge.svg?branch=master)](https://coveralls.io/github/blok/mock?branch=master)

[![Packagist](https://img.shields.io/packagist/v/blok/mock.svg)](https://packagist.org/packages/blok/mock)
[![Packagist](https://poser.pugx.org/blok/mock/d/total.svg)](https://packagist.org/packages/blok/mock)
[![Packagist](https://img.shields.io/packagist/l/blok/mock.svg)](https://packagist.org/packages/blok/mock)

Package description: CHANGE ME

## Installation

Install via composer
```bash
composer require blok/mock
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
blok\mock\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
blok\mock\Facades\mock::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="blok\mock\ServiceProvider" --tag="config"
```

## Usage

CHANGE ME

## Security

If you discover any security related issues, please email 
instead of using the issue tracker.

## Credits

- [](https://github.com/blok/mock)
- [All contributors](https://github.com/blok/mock/graphs/contributors)

This package is bootstrapped with the help of
[blok/laravel-package-generator](https://github.com/blok/laravel-package-generator).
