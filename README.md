# Flexer
![Version](https://img.shields.io/packagist/v/ryanl/flexer)
![PHP Version](https://img.shields.io/packagist/php-v/ryanl/flexer)
![Total Downloads](https://img.shields.io/packagist/dt/ryanl/flexer)
![License](https://img.shields.io/packagist/l/ryanl/flexer)

### Description:
A simple, but robust implementation of PSR11, that support multiple types of definitions for
your dependencies
---

## Getting Started

Similar to what is done with PHP-DI

## Installation
Install Flexer with Composer:
```shell
composer require ryanl/flexer
```
---
## Usage
Instantiate an instance of the container:
```php
$container = new \Flexer\Container();
```
With autowiring, Flexer can handle most cases of object instantiation. Here is a list of cases Flexer can cover with _zero configuration_.

### Classes with:
* No constructor
* Empty constructor
* Constructor with optional parameters
* Constructor parameters that are objects of classes fitting the previous cases.

## Defining How to Instantiate Complex Objects
There are two possible syntaxes for adding definitions to Flexer:

### Directly in the constructor:
```php
$container = new \Flexer\Container([
   $id => $definition 
]);
```

### Using the `add` method:
```php
$container = new \Flexer\Container();
$container->add($id, $definition)
```

### Id
The id can be, as defined in PSR-11, the "Identifier of the entry to look for", so it can be an arbitrary identifier. However, the most common practice is to use the fully qualified class name (including its namespace).

```php
$container = new \Flexer\Container();
$container->add(\Test\Sample\NormalClass::class, $definition)
```

### Definition
The definition is the instruction given to the container to instantiate your class. Currently, Flexer accepts the following types of `$definition`:

* Closure

```php
$definition = fn() => new \Test\Sample\NormalClass();
$container->add($id, $definition);
```

* Function Name

```php
function getNormalClassInstance(): \Test\Sample\NormalClass
{
    return new \Test\Sample\NormalClass();
}
$container->add($id, 'getNormalClassInstance');
```

* Class Closure Object

```php
$container->add($id, \Test\Sample\NormalClass::create(...));
```

* Object Instance

```php
$container->add($id, new \Test\Sample\NormalClass());
```

> Despite the numerous possibilities for defining your dependencies, we recommend using deferred alternatives, where the dependency is only instantiated when it becomes necessary, avoiding unnecessary memory allocation.

## Tip
A more elegant way to manage your definitions is to separate them into a file that provides an array of definitions:

```php
# dependencies.php

<?php

declare(strict_types=1);

return [
    \Test\Sample\NormalClass::class => fn () => new \Test\Sample\NormalClass(),
    \PDO::class => function (): \PDO {
        return new PDO('sqlite::memory');
    }
];
```

```php
# index.php

<?php

declare(strict_types=1);

$container = new \Flexer\Container(require_once 'dependencies.php');
```

## Tests
To execute the test suite, clone the repository and then run the `test` script on composer.json
```bash
git clone https://github.com/ryanlimadotdev/flexer.git
composer install
composer test
```

## Contributing
Anyone who wishes and is available to collaborate with the project should feel free to create a fork of the project and make a pull request suggestion with the modifications they deem pertinent. Just pay attention to carrying out the appropriate tests and following the code style policy present in the project in:
```bash
composer analyse
```
