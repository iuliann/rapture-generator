# Rapture PHP code Generator

[![PhpVersion](https://img.shields.io/badge/php-7.0-orange.svg?style=flat-square)](#)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](#)

Message sending for various services.

## Requirements

- PHP v7.0
- php-pcre

## Install

```
composer install iuliann/rapture-generator
```

## Quick start

```php
$class = new PhpClass('Test');
        $class->setNamespace('Demo')
            ->setIsAbstract(true)
            ->setIsFinal(true)
            ->setExtends('\Rapture\Component\Definition\ClassAbstract')
            ->addImplements('\Rapture\Component\Definition\ClassInterface')
            ->addTrait('\Rapture\Component\Definition\ClassTrait')
            ->addConstant('status_on', 1)
            ->addConstant('status_off', 2)
            ->addProperty(new PhpProperty('status', 'self::STATUS_OFF', PhpMethod::KEYWORD_PROTECTED))
            ->addMethod(new PhpMethod('setStatus', '$this->status = $status;', PhpMethod::KEYWORD_PUBLIC, [['status', 'int', 'self::STATUS_OFF']]))
            ->setComment(new PhpComment(['Class Demo', '', '@see HelloWorld']))
        ;

file_put_contents('User.php', PhpRender::renderClass($class));
```
Result:
```php
<?php

namespace Demo;

use Rapture\Component\Definition\ClassAbstract;
use Rapture\Component\Definition\ClassInterface;
use Rapture\Component\Definition\ClassTrait;

/**
 * Class Demo
 * 
 * @see HelloWorld
 */
final abstract class Test extends ClassAbstract implements ClassInterface
{
    use ClassTrait;

    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $status = self::STATUS_OFF;

    public function setStatus(int $status = self::STATUS_OFF)
    {
        $this->status = $status;

        return $this;
    }
}
```

## About

### Author

Iulian N. `rapture@iuliann.ro`

### Testing

```
cd ./test && phpunit
```

### License

Rapture PHP code Generator is licensed under the MIT License - see the `LICENSE` file for details.
