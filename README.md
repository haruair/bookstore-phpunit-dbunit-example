# Bookstore

An example project for PHPUnit and DbUnit.

## Getting Started

Create tables into your database first. Than, update DSN configuration.

```
$ cp phpunit.xml.dist phpunit.xml
$ vim phpunit.xml # edit the config
```

Install dependancies via composer.

```
$ composer install
$ vendor/bin/phpunit
```
