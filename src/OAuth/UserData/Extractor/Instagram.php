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

use OAuth\UserData\Utils\ArrayUtils;

/**
 * Class Instagram
 * @package OAuth\UserData\Extractor
 */
class Instagram extends LazyExtractor
{

    const REQUEST_PROFILE = '/users/self';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::getDefaultLoadersMap(),
            self::getDefaultNormalizersMap(),
            self::getSupportedFields()
        );
    }

    protected static function getSupportedFields()
    {
        return array(
            self::FIELD_UNIQUE_ID,
            self::FIELD_USERNAME,
            self::FIELD_FULL_NAME,
            self::FIELD_FIRST_NAME,
            self::FIELD_LAST_NAME,
            self::FIELD_DESCRIPTION,
            self::FIELD_WEBSITES,
            self::FIELD_IMAGE_URL,
            self::FIELD_PROFILE_URL,
            self::FIELD_EXTRA
        );
    }

    protected function profileLoader()
    {
        return json_decode($this->service->request(self::REQUEST_PROFILE), true);
    }

    protected function uniqueIdNormalizer($data)
    {
        return isset($data['data']['id']) ? $data['data']['id'] : null;
    }

    protected function usernameNormalizer($data)
    {
        return isset($data['data']['username']) ? $data['data']['username'] : null;
    }

    protected function fullNameNormalizer($data)
    {
        return isset($data['data']['full_name']) ? $data['data']['full_name'] : null;
    }

    protected function firstNameNormalizer()
    {
        $fullName = $this->getField(self::FIELD_FULL_NAME);
        if ($fullName) {
            $names = explode(' ', $fullName);

            return $names[0];
        }

        return null;
    }

    protected function lastNameNormalizer()
    {
        $fullName = $this->getField(self::FIELD_FULL_NAME);
        if ($fullName) {
            $names = explode(' ', $fullName);

            return $names[sizeof($names) - 1];
        }

        return null;
    }

    protected function descriptionNormalizer($data)
    {
        return isset($data['data']['bio']) ? $data['data']['bio'] : null;
    }

    protected function websitesNormalizer($data)
    {
        $websites = array();
        if (isset($data['data']['website'])) {
            $websites[] = $data['data']['website'];
        }

        return $websites;
    }

    protected function profileUrlNormalizer()
    {
        $username = $this->getField(self::FIELD_USERNAME);

        if (null !== $username) {
            return sprintf('http://instagram.com/%s', $username);
        }

        return null;
    }

    protected function imageUrlNormalizer($data)
    {
        return isset($data['data']['profile_picture']) ? $data['data']['profile_picture'] : null;
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data['data'], array(
            'id',
            'username',
            'full_name',
            'website',
            'profile_picture',
            'bio',
        ));
    }
}
