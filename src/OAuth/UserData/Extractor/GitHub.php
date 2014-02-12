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
 * Class GitHub
 * @package OAuth\UserData\Extractor
 */
class GitHub extends LazyExtractor
{
    const REQUEST_PROFILE = '/user';
    const REQUEST_EMAIL = '/user/emails';

    public function __construct()
    {
        parent::__construct(
            self::getLoadersMap(),
            self::getDefaultNormalizersMap(),
            self::getSupportedFields()
        );
    }

    protected function profileLoader()
    {
        return json_decode($this->service->request(self::REQUEST_PROFILE), true);
    }

    protected function emailLoader()
    {
        return json_decode(
            $this->service->request(
                self::REQUEST_EMAIL,
                'GET',
                array(),
                array('Accept' => 'application/vnd.github.v3')
            ),
            true
        );
    }

    protected static function getSupportedFields()
    {
        return array(
            self::FIELD_UNIQUE_ID,
            self::FIELD_USERNAME,
            self::FIELD_FIRST_NAME,
            self::FIELD_LAST_NAME,
            self::FIELD_FULL_NAME,
            self::FIELD_EMAIL,
            self::FIELD_LOCATION,
            self::FIELD_DESCRIPTION,
            self::FIELD_IMAGE_URL,
            self::FIELD_PROFILE_URL,
            self::FIELD_VERIFIED_EMAIL,
            self::FIELD_EXTRA
        );
    }

    protected static function getLoadersMap()
    {
        return array_merge(self::getDefaultLoadersMap(), array(
            self::FIELD_EMAIL          => 'email',
            self::FIELD_VERIFIED_EMAIL => 'email'
        ));
    }

    protected function uniqueIdNormalizer($data)
    {
        return isset($data['id']) ? $data['id'] : null;
    }

    protected function usernameNormalizer($data)
    {
        return isset($data['login']) ? $data['login'] : null;
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

    protected function fullNameNormalizer($data)
    {
        return isset($data['name']) ? $data['name'] : null;
    }

    protected function emailNormalizer($emails)
    {
        $email = $this->getEmailObject($emails);

        return $email['email'];
    }

    protected function locationNormalizer($data)
    {
        return isset($data['location']) ? $data['location'] : null;
    }

    protected function descriptionNormalizer($data)
    {
        return isset($data['bio']) ? $data['bio'] : null;
    }

    protected function imageUrlNormalizer($data)
    {
        return isset($data['avatar_url']) ? $data['avatar_url'] : null;
    }

    protected function profileUrlNormalizer($data)
    {
        return isset($data['html_url']) ? $data['html_url'] : null;
    }

    protected function verifiedEmailNormalizer($emails)
    {
        $email = $this->getEmailObject($emails);

        return $email['verified'];
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data, array(
            'id',
            'login',
            'name',
            'location',
            'bio',
            'avatar_url',
            'html_url'
        ));
    }

    /**
     * Get the right email address from the one's the user provides.
     *
     * @param array $emails The array of email array objects provided by GitHub.
     *
     * @return array The email array object.
     */
    private function getEmailObject($emails)
    {
        // Try to find an email address which is primary and verified.
        foreach ($emails as $email) {
            if ($email['primary'] && $email['verified']) {
                return $email;
            }
        }

        // Try to find an email address which is primary.
        foreach ($emails as $email) {
            if ($email['primary']) {
                return $email;
            }
        }

        return $emails[0];
    }
}
