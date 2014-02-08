PHPoAuthUserData
================

Extension library for [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib) to abstract the process of
extracting user profile data from various OAuth providers (Facebook, Twitter, Linkedin, etc).

[![Build Status](https://travis-ci.org/Oryzone/PHPoAuthUserData.png?branch=master)](https://travis-ci.org/Oryzone/PHPoAuthUserData)
[![Latest Stable Version](https://poser.pugx.org/oryzone/oauth-user-data/v/stable.png)](https://packagist.org/packages/oryzone/oauth-user-data)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Oryzone/PHPoAuthUserData/badges/quality-score.png?s=3f68374324b1617285059a6c6853c8032ceb76ae)](https://scrutinizer-ci.com/g/Oryzone/PHPoAuthUserData/)
[![Code Coverage](https://scrutinizer-ci.com/g/Oryzone/PHPoAuthUserData/badges/coverage.png?s=bc2805020a5ddbadda5f5114d0b7592745a79f5a)](https://scrutinizer-ci.com/g/Oryzone/PHPoAuthUserData/)
[![Dependency Status](https://www.versioneye.com/user/projects/52f51399ec1375dc7b00015e/badge.png)](https://www.versioneye.com/user/projects/52f51399ec1375dc7b00015e)
[![Total Downloads](https://poser.pugx.org/oryzone/oauth-user-data/downloads.png)](https://packagist.org/packages/oryzone/oauth-user-data)

### Contents

- [Abstract](#abstract)
- [License](#license)
- [Installation](#installation)
- [Providers support](#providers-support)
- [Mapped fields and methods](#mapped-fields-and-methods)
- [Examples](#examples)
- [How to contribute](#how-to-contribute)
- [Contributors](#contributos)
- [Tests](#tests)

## Abstract

OAuth 1 and 2 are great standard protocols to authenticate users in our apps and the library [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib)
allow us to do it in a very simple and concise manner. Anyway we often need to extract various information about the
user after he has been authenticated. Unfortunately this is something that is not standardized and obviously each OAuth
provider manages user data in very specific manner according to its purposes.

So each provider offers specific APIs with specific data schemes to extract data about the authenticated
user.

That's not a big deal if we build apps that adopts a single OAuth provider, but if we want to adopt more of them things
can get really cumbersome.

Just to make things clearer suppose you want to allow users in your app to sign up with Facebook, Twitter and Linkedin.
Probably, to increase conversion rate and speed up the sign up process, you may want to populate the user profile on your
app by copying data from the OAuth provider user profile he used to sign up. Yes, you have to deal with 3 different sets of
APIs and data schemes! And suppose you would be able to add GitHub and Google one day, that will count for 5
different APIs and data schemes... not so maintainable, isn't it?

Ok, relax... this library exists to ease this pain! It provides an abstraction layer on the top of [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib)
library to extract user data from the OAuth providers you already integrated in your app.

It offers a uniform and (really) simple interface to extract the most interesting and common user data such as *Name*,
*Username*, *Id* and so on.

Just to give you a quick idea of what is possible with the library have a look at the following snippet:

``` php
// $service is an istance of \OAuth\Common\Service\ServiceInterface (eg. the "Facebook" service) with a valid access token
$extractorFactory = new \OAuth\UserData\ExtractorFactory();
$extractor = $extractorFactory->get($service); // get the extractor for the given service
echo $extractor->getUniqueId(); // prints out the unique id of the user
echo $extractor->getUsername(); // prints out the username of the user
echo $extractor->getImageUrl(); // prints out the url of the user profile image
```

## License

This library is licensed under the [MIT license](LICENSE).

## Installation

This library can be found on [Packagist](https://packagist.org/packages/oryzone/oauth-user-data).
The recommended way to install this is through composer.

Edit your `composer.json` and add:

``` json
{
    "require": {
        "oryzone/oauth-user-data": "~1.0@dev"
    }
}
```

And install dependencies:

``` bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

## Providers support

Currently there are extractors for the following providers:

- Facebook
- Twitter

More to come (obviously)! Want to [contribute](#how-to-contribute)?

## Mapped fields and methods

The library leverages around the concept of *extractors*. An extractor is a specific implementation of the logic to
retrieve data for a given OAuth provider.

Each extractor can retrieve the following user data fields:

- *uniqueId*
- *username*
- *firstName*
- *lastName*
- *fullName*
- *email*
- *location*
- *description*
- *imageUrl*
- *profileUrl*
- *websites* (array)

For each field you have convenience methods to get the value of the field or to check if it is supported by the given
provider:

- `supportsUniqueId()`
- `getUniqueId()`
- `supportsUsername()`
- `getUsername()`
- `supportsFirstName()`
- `getFirstName()`
- `supportsLastName()`
- `getLastName()`
- `supportsFullName()`
- `getFullName()`
- `supportsEmail()`
- `getEmail()`
- `supportsLocation()`
- `getLocation()`
- `supportsDescription()`
- `getDescription()`
- `supportsImageUrl()`
- `getImageUrl()`
- `supportsProfileUrl()`
- `getProfileUrl()`
- `supportsWebsites()`
- `getWebsites()`

If you try to get a field that is not supported or it has not been set by the user on its profile you will get a `null`
value.

All the other other data offered by the service API is mapped under a special *extra* array accessible with the following
methods:

- `supportsExtra()`
- `getExtra($key)`
- `getExtras()`

You can have a look at the [ExtractorInterface](src/OAuth/UserData/Extractor/ExtractorInterface.php) *docblocks* if you want
a better understanding of what every method does.

## Examples

TODO

## How to contribute

TODO

## Contributors

- [Luciano Mammino](https://github.com/lmammino)
- [All contributors](https://github.com/Oryzone/PHPoAuthUserData/graphs/contributors)

## Tests

To run the tests, you must install dependencies with `composer install --dev`