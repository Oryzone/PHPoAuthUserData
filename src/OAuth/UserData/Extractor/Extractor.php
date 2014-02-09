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
 * Class Extractor
 * @package OAuth\UserData\Extractor
 */
class Extractor implements ExtractorInterface
{
    /**
     * @var \OAuth\Common\Service\ServiceInterface $service
     */
    protected $service;

    /**
     * Array of supported fields
     * @var array $supports
     */
    protected $supports;

    /**
     * Associative array with all the fields value
     * @var array
     */
    protected $fields;

    /**
     * Constructor
     *
     * @param array $supports
     * @param array $fields
     */
    public function __construct($supports = array(), $fields = array())
    {
        $this->supports = $supports;
        $this->fields = $fields;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsUniqueId()
    {
        return $this->isFieldSupported(self::FIELD_UNIQUE_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId()
    {
        return $this->getField(self::FIELD_UNIQUE_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsUsername()
    {
        return $this->isFieldSupported(self::FIELD_USERNAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->getField(self::FIELD_USERNAME);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsFirstName()
    {
        return $this->isFieldSupported(self::FIELD_FIRST_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstName()
    {
        return $this->getField(self::FIELD_FIRST_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsLastName()
    {
        return $this->isFieldSupported(self::FIELD_LAST_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getLastName()
    {
        return $this->getField(self::FIELD_LAST_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsFullName()
    {
        return $this->isFieldSupported(self::FIELD_FULL_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getFullName()
    {
        return $this->getField(self::FIELD_FULL_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsEmail()
    {
        return $this->isFieldSupported(self::FIELD_EMAIL);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {
        return $this->getField(self::FIELD_EMAIL);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsLocation()
    {
        return $this->isFieldSupported(self::FIELD_LOCATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getLocation()
    {
        return $this->getField(self::FIELD_LOCATION);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsDescription()
    {
        return $this->isFieldSupported(self::FIELD_DESCRIPTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->getField(self::FIELD_DESCRIPTION);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsImageUrl()
    {
        return $this->isFieldSupported(self::FIELD_IMAGE_URL);
    }

    /**
     * {@inheritDoc}
     */
    public function getImageUrl()
    {
        return $this->getField(self::FIELD_IMAGE_URL);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsProfileUrl()
    {
        return $this->isFieldSupported(self::FIELD_PROFILE_URL);
    }

    /**
     * {@inheritDoc}
     */
    public function getProfileUrl()
    {
        return $this->getField(self::FIELD_PROFILE_URL);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsWebsites()
    {
        return $this->isFieldSupported(self::FIELD_WEBSITES);
    }

    /**
     * {@inheritDoc}
     */
    public function getWebsites()
    {
        return $this->getField(self::FIELD_WEBSITES);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsVerifiedEmail()
    {
        return $this->isFieldSupported(self::FIELD_VERIFIED_EMAIL);
    }

    /**
     * {@inheritDoc}
     */
    public function isEmailVerified()
    {
        return $this->getField(self::FIELD_VERIFIED_EMAIL);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsExtra()
    {
        return $this->isFieldSupported(self::FIELD_EXTRA);
    }

    /**
     * {@inheritDoc}
     */
    public function getExtra($key)
    {
        $extras = $this->getExtras();

        return (isset($extras[$key]) ? $extras[$key] : null);
    }

    /**
     * {@inheritDoc}
     */
    public function getExtras()
    {
        return $this->getField(self::FIELD_EXTRA);
    }

    /**
     * {@inheritDoc}
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * Get the value for a given field
     *
     * @param  string     $field the name of the field
     * @return null|mixed
     */
    protected function getField($field)
    {
        if ($this->isFieldSupported($field) && isset($this->fields[$field])) {
            return $this->fields[$field];
        }

        return null;
    }

    /**
     * Check if a given field is supported
     *
     * @param  string $field the name of the field
     * @return bool
     */
    protected function isFieldSupported($field)
    {
        return in_array($field, $this->supports);
    }

    /**
     * Get an array listing all fields names
     *
     * @return string[]
     */
    protected static function getAllFields()
    {
        return array(
            self::FIELD_UNIQUE_ID,
            self::FIELD_USERNAME,
            self::FIELD_FIRST_NAME,
            self::FIELD_LAST_NAME,
            self::FIELD_FULL_NAME,
            self::FIELD_EMAIL,
            self::FIELD_DESCRIPTION,
            self::FIELD_LOCATION,
            self::FIELD_PROFILE_URL,
            self::FIELD_IMAGE_URL,
            self::FIELD_WEBSITES,
            self::FIELD_VERIFIED_EMAIL,
            self::FIELD_EXTRA
        );
    }
}
