# A package to handle basic caching requirements through Redis pipelines,  allowing handling wildcard cache clears

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amitavroy/rediscache.svg?style=flat-square)](https://packagist.org/packages/amitavroy/rediscache)
[![Build Status](https://img.shields.io/travis/amitavroy/rediscache/master.svg?style=flat-square)](https://travis-ci.org/amitavroy/rediscache)
[![Quality Score](https://img.shields.io/scrutinizer/g/amitavroy/rediscache.svg?style=flat-square)](https://scrutinizer-ci.com/g/amitavroy/rediscache)
[![Total Downloads](https://img.shields.io/packagist/dt/amitavroy/rediscache.svg?style=flat-square)](https://packagist.org/packages/amitavroy/rediscache)

This is where your description should go. Try and limit it to a paragraph or two.

## Installation

You can install the package via composer:

```bash
composer require amitavroy/rediscache
```

## Usage

A Facade is provided to get perform all the common tasks with the packages like:

Any data from redis cache can be requested using:
``` php
RedisCache::get("key_name");
```

Any data can be stored in redis using:
``` php
RedisCache::set("key_name", $data);
```

Forget/Delete a key
``` php
RedisCache::forget("key_name");
```

Forget/Delete keys through wild card pattern match
``` php
RedisCache::forget("pattern", true);
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Security

If you discover any security related issues, please email reachme@amitavroy.com instead of using the issue tracker.

## Credits

- [Amitav Roy](https://github.com/amitavroy)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
