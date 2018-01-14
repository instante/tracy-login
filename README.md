# Instante Tracy Login


[![Build Status](https://travis-ci.org/instante/tracy-login.svg?branch=master)](https://travis-ci.org/instante/tracy-login)
[![Downloads this Month](https://img.shields.io/packagist/dm/instante/tracy-login.svg)](https://packagist.org/packages/instante/tracy-login)
[![Latest stable](https://img.shields.io/packagist/v/instante/tracy-login.svg)](https://packagist.org/packages/instante/tracy-login)


## Installation

The best way to install Instante Tracy Login is using  [Composer](http://getcomposer.org/):

```sh
$ composer require instante/tracy-login
```

## Configuration

Add new extension to config (_e.g. extensions.neon_):

```
extensions:
    debugLogin: Instante\Tracy\Login\DI\DebugLoginExtension
```

Then you should enable it in your local config. **Never do that on production server!**

```
debugLogin:
    enabled: true
```

## Optional configuration

Login bar natively works with Instante/skeleton doctrine user. Default User class is App\Model\User\User. You can change it in setup:

```
debugLogin:
    dao:
        entity: Your\Custom\User
```
Or
```
debugLogin:
    dao: "Instante\Tracy\Login\DoctrineUserDao(Your\Custom\User)"
```

You can write your own UserDao which implements IUserDao. Then you have to update setup:

```
debugLogin:
    dao: "Your\Custom\Dao"
```

## Identifier

Default identifier is 'email' so method 'getEmail()' will be called. You can change it in setup:

```
debugLogin:
    identifier: "fullName"
```

and then 'getFullName()' will be called. 
But you can add as many methods as you want:

```
debugLogin:
    identifier: {"email", "fullName"}
```

and then both, 'getEmail()' and 'getFullName()' will be called.