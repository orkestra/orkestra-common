Orkestra Common
===============

[![Build Status](https://travis-ci.org/orkestra/orkestra-common.png?branch=master)](https://travis-ci.org/orkestra/orkestra-common)

Provides useful functionality for any Doctrine 2 based project including:

* Transparent user/server timezone conversion
* Encrypted string fields
* Enumerations


Installation
------------

The easiest way to add orkestra-common to your project is using composer.

Add orkestra-common to your `composer.json` file:

``` json
{
    "require": {
        "orkestra/common": "dev-master"
    }
}
```

Then run `composer install` or `composer update`.


Configuration
-------------

Each feature provided by common requires a bit of set up.

### Dates and Times

Orkestra's custom DateTime implementation allows for easier conversion between server and user time, without
the need for a full-blown localization or internationalization implementation.

```php
# /path/to/your/bootstrap.php
<?php

use Doctrine\DBAL\Types\Type;

// DateTime types
Type::overrideType('datetime', 'Orkestra\Common\DbalType\DateTimeType');
Type::overrideType('date', 'Orkestra\Common\DbalType\DateType');
```


### Encrypted string fields

The `encrypted_string` field type transparently encrypts and decrypts data when persisting and hydrating entities.


### Enumerations

Enumerations are not supported by PHP nor Doctrine 2 out of the box. Common provides a base class for your own
custom enumeration implementations. Each enumeration requires the enumeration itself and a corresponding DbalType
class to integrate the enumeration with Doctrine 2.
