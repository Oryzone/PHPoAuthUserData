<?php

/*
 * This file is part of the Oryzone PHPoAuthUserData package <https://github.com/Oryzone/PHPoAuthUserData>.
 *
 * (c) Oryzone, developed by Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OAuth\UserData\Extractor;

/**
 * Interface ExtractorInterface
 * @package OAuth\UserData\Extractor
 */
interface ExtractorInterface
{
    /**
     * Field names constants
     */
    const FIELD_UNIQUE_ID = 'uniqueId';
    const FIELD_USERNAME = 'username';
    const FIELD_FIRST_NAME = 'firstName';
    const FIELD_LAST_NAME = 'lastName';
    const FIELD_FULL_NAME = 'fullName';
    const FIELD_EMAIL = 'email';
    const FIELD_LOCATION = 'location';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_IMAGE_URL = 'imageUrl';
    const FIELD_PROFILE_URL = 'profileUrl';
    const FIELD_WEBSITES = 'websites';
    const FIELD_VERIFIED_EMAIL = 'verifiedEmail';
    const FIELD_EXTRA = 'extra';

    /**
     * @param  \OAuth\Common\Service\ServiceInterface $service
     * @return void
     */
    public function setService($service);

    /**
     * Check if the current provider supports a unique id
     *
     * @return bool
     */
    public function supportsUniqueId();

    /**
     * Get the unique id of the user
     *
     * @return string
     */
    public function getUniqueId();

    /**
     * Check if the current provider supports a username
     *
     * @return bool
     */
    public function supportsUsername();

    /**
     * Get the username
     *
     * @return string
     */
    public function getUsername();

    /**
     * Check if the current provider supports a first name
     *
     * @return bool
     */
    public function supportsFirstName();

    /**
     * Get the first name
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Check if the current provider supports a last name
     * @return bool
     */
    public function supportsLastName();

    /**
     * Get the last name
     *
     * @return string
     */
    public function getLastName();

    /**
     * Check if the current provider supports a full name
     *
     * @return bool
     */
    public function supportsFullName();

    /**
     * Get the full name
     *
     * @return string
     */
    public function getFullName();

    /**
     * Check ig the current provider supports an email
     *
     * @return bool
     */
    public function supportsEmail();

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Check if the current provider supports a location
     *
     * @return bool
     */
    public function supportsLocation();

    /**
     * Get the location
     *
     * @return string
     */
    public function getLocation();

    /**
     * Check if the current provider supports a description
     *
     * @return bool
     */
    public function supportsDescription();

    /**
     * Get the description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Check if the current provider supports an image url
     *
     * @return bool
     */
    public function supportsImageUrl();

    /**
     * Get the image url
     *
     * @return string
     */
    public function getImageUrl();

    /**
     * Check if the current provider supports a profile url
     *
     * @return bool
     */
    public function supportsProfileUrl();

    /**
     * Get the profile url
     *
     * @return string
     */
    public function getProfileUrl();

    /**
     * Check if the current provider supports websites
     *
     * @return bool
     */
    public function supportsWebsites();

    /**
     * Get websites
     *
     * @return array
     */
    public function getWebsites();

    /**
     * Check if the current provider supports the "verified" field
     *
     * @return bool
     */
    public function supportsVerifiedEmail();

    /**
     * Get the verified
     *
     * @return bool
     */
    public function isEmailVerified();

    /**
     * Check if the current provider supports extra data
     *
     * @return bool
     */
    public function supportsExtra();

    /**
     * Get an extra attribute
     *
     * @param  string $key
     * @return array
     */
    public function getExtra($key);

    /**
     * Get the extras array
     *
     * @return array
     */
    public function getExtras();
}
