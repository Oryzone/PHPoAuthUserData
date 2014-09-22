PHPoAuthUserData
================

Extension library for [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib) to abstract the process of
extracting user profile data from various OAuth providers (Facebook, Twitter, Linkedin, etc).

[![Build Status](https://travis-ci.org/Oryzone/PHPoAuthUserData.png?branch=master)](https://travis-ci.org/Oryzone/PHPoAuthUserData)
[![Latest Stable Version](https://poser.pugx.org/oryzone/oauth-user-data/v/stable.png)](https://packagist.org/packages/oryzone/oauth-user-data)
[![Latest Unstable Version](https://poser.pugx.org/oryzone/oauth-user-data/v/unstable.png)](https://packagist.org/packages/oryzone/oauth-user-data)
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
- GitHub (Thanks to @cmfcmf)
- Harvest (Thanks to @mneuhaus)
- Instagram
- Linkedin
- Twitter

More to come (obviously)! Want to [contribute](#how-to-contribute)?

## Mapped fields and methods

The library leverages around the concept of *extractors*. An extractor is a specific implementation of the logic to
retrieve data for a given OAuth provider.

Each extractor can retrieve the following user data fields:

- *uniqueId* (string)
- *username* (string)
- *firstName* (string)
- *lastName* (string)
- *fullName* (string)
- *email* (string)
- *location* (string)
- *description* (string)
- *imageUrl* (string)
- *profileUrl* (string)
- *websites* (array)
- *verifiedEmail* (bool)

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
- `supportsVerifiedEmail()`
- `isEmailVerified()`

If you try to get a field that is not supported or it has not been set by the user on its profile you will get a `null`
value.

All the other other data offered by the service API is mapped under a special *extra* array accessible with the following
methods:

- `supportsExtra()`
- `getExtra($key)`
- `getExtras()`

You can have a look at the [ExtractorInterface](src/OAuth/UserData/Extractor/ExtractorInterface.php) *docblocks* if you want
a better understanding of what every method does.

**NOTE**: In many providers some user data fields are available only if you set the proper scopes/settings for your OAuth app.

## Examples

Examples are available in the [examples](examples) directory.

## How to contribute

This project need a lot of work and Github is the perfect place to share the burden. So everyone is welcome to help and
submit a pull request.

Keep in mind that the submitted code should be conform to [PSR-2 standard](http://www.php-fig.org/psr/psr-2/) and be
tested with [PHPUnit](http://phpunit.de/).

Probably you want to contribute by submitting a new Extractor. So let shed some light on some concepts involved in writing a new one.

### Writing an Extractor

Extractors defines the logic to request information to a given service API and to normalize the received data according
to a common [interface](src/OAuth/UserData/Extractor/ExtractorInterface.php).
The most basic way to define an extractor is to write a class that implements the [ExtractorInterface](src/OAuth/UserData/Extractor/ExtractorInterface.php)
(that is pretty self-explanatory). You could extend the class [Extractor](src/OAuth/UserData/Extractor/Extractor.php) that implements most of the needed code to get you started.
Anyway, extractors should **really** extend the class [LazyExtractor](src/OAuth/UserData/Extractor/LazyExtractor.php) where possible
because it acts as a boilerplate to define highly optimized extractors. This class easily allows you to implement extractors
that **lazy loads** data (perform requests only when needed to) and **caches** data (does not make the same request more than once and avoids
normalizing the same data more than once). Everything is done behind the scenes, so you'll need to focus only on methods that define how to make
requests and how to normalize data.

To understand how to write a new extractor by adopting the [LazyExtractor](src/OAuth/UserData/Extractor/LazyExtractor.php) we need to clarify
some concepts:

  - **Supported fields**: an array of the fields (you should use field constants from the [ExtractorInterface](src/OAuth/UserData/Extractor/ExtractorInterface.php)) that can be extracted.
  - **Loaders**: methods whose responsibility is to trigger the proper request to the OAuth provider endpoint to load a specific set of raw data. Generally
you need to define a loader for each block of information that could be retrieved from the endpoint. this methods must have the suffix `Loader` in their name.
Most of the service will allow you to retrieve all the user data with a single request, so, in this cases, you would have only a single loader method (eg: `profileLoader`).
  - **Normalizers**: methods that accept raw data (the one previously fetched by some loader method) and uses it to extract the value for a given field.
Usually you have a normalizer for each supported field. Normalizers methods must have the suffix `Normalizer` (eg. `uniqueIdNormalizer` or `descriptionNormalizer`).
  - **LoadersMap**: an array that associates supported fields (keys) to loaders methods (values). Loaders methods must be referenced without the `Loader` suffix.
Most of the time, if you have only the `profileLoader` loader you will have an array with all fields mapping to the string `profile`.
  - **NormalizersMap**: an array that associates supported fields (keys) to the related normalizer methods (values). Normalizers methods must be
referenced without the `Normalizer` suffix. It's highly suggested to use the same name of the field for its related normalizer, so, most of the time,
you will end up by having an array that maps field constants to the same field constant (eg. `array(self::FIELD_UNIQUE_ID => self::FIELD_UNIQUE_ID)`) for
every supported field.

Once you defined *Supported Fields*, *Loaders*, *Normalizers*, *Loaders Map* and *Normalizers Map* from within your new extractor class you must
wire them to the underlying logic by passing them to the parent constructor. So if you defined methods such as `getSupportedField`, `getLoadersMap` and `getNormalizersMap`
you will end up with a constructor like this:

```php
public function __construct()
{
    parent::__construct(
        self::getLoadersMap(),
        self::getNormalizersMap(),
        self::getSupportedFields()
    );
}
```

### A small example

I wrote [a dedicated blog post](http://loige.com/writing-a-new-extractor-for-php-oauth-user-data/) to present a small example that explains,
step by step, how to write a new extractor.

## Contributors

- [Luciano Mammino](https://github.com/lmammino)
- [All contributors](https://github.com/Oryzone/PHPoAuthUserData/graphs/contributors)

## Tests

To run the tests, you must install dependencies with `composer install --dev`
