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

## Abstract

OAuth 1 and 2 are great standard protocols to authenticate users in our apps and the library [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib)
allow us to do it in a very simple and concise manner. Anyway we often need to extract various information about the
user after he has been authenticated. Unfortunately this is something that is not standardized and obviously each OAuth
provider manages user data in very specific manner according to its purposes.
So each provider uses specific APIs and returns specific data when we want to extract informations about the authenticated
user. That's not a big deal if we build apps that adopts a single OAuth provider, but if we want to adopt more of them
could become cumbersome to handle user data extraction from each provider.
Just to make things clearer suppose you want to allow users in your app to sign up with Facebook, Twitter and Linkedin.
Probably, to increase conversion rate and speed up the sign up process, you may want to populate the user profile on your
app by copying data from the OAuth provider user profile he used to sign up. Yes, you have to deal with 3 different sets of
APIs and data schemes! And suppose you would be able to add GitHub and Google one day, that will make the count reach 5
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

TODO

## Providers support

- Facebook
- Twitter

Obviously more to come!

## Mapped fields

TODO

## Examples

TODO

## How to contribute

TODO

## Contributors

- [Luciano Mammino](https://github.com/lmammino)
- [All contributors](https://github.com/Oryzone/PHPoAuthUserData/graphs/contributors)

## Tests

To run the tests, you must install dependencies with `composer install --dev`