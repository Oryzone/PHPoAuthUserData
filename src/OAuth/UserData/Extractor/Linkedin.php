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
 * Class Linkedin
 * @package OAuth\UserData\Extractor
 */
class Linkedin extends LazyExtractor
{
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

    /**
     * Builds the query string needed to retrieve profile user data
     *
     * @return string
     */
    public static function createProfileRequestUrl()
    {
        $fields = array(
            'id',
            'summary',
            'member-url-resources',
            'email-address',
            'first-name',
            'last-name',
            'headline',
            'location',
            'industry',
            'picture-url',
            'public-profile-url'
        );

        return sprintf('/people/~:(%s)?format=json', implode(",", $fields));
    }

    protected static function getSupportedFields()
    {
        return array(
            self::FIELD_UNIQUE_ID,
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

    protected function profileLoader()
    {
        return json_decode($this->service->request(self::createProfileRequestUrl()), true);
    }

    protected function uniqueIdNormalizer($data)
    {
        return $data['id'];
    }

    protected function firstNameNormalizer($data)
    {
        return isset($data['firstName']) ? $data['firstName'] : null;
    }

    protected function lastNameNormalizer($data)
    {
        return isset($data['lastName']) ? $data['lastName'] : null;
    }

    protected function fullNameNormalizer()
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }

    protected function emailNormalizer($data)
    {
        return isset($data['emailAddress']) ? $data['emailAddress'] : null;
    }

    protected function descriptionNormalizer($data)
    {
        return isset($data['summary']) ? $data['summary'] : null;
    }

    protected function imageUrlNormalizer($data)
    {
        return isset($data['pictureUrl']) ? $data['pictureUrl'] : null;
    }

    protected function profileUrlNormalizer($data)
    {
        return isset($data['publicProfileUrl']) ? $data['publicProfileUrl'] : null;
    }

    protected function locationNormalizer($data)
    {
        return isset($data['location']['name']) ? $data['location']['name'] : null;
    }

    protected function websitesNormalizer($data)
    {
        $websites = array();
        if (isset($data['memberUrlResources'], $data['memberUrlResources']['values'])) {
            foreach ($data['memberUrlResources']['values'] as $resource) {
                if (isset($resource['url'])) {
                    $websites[] = $resource['url'];
                }
            }
        }

        return $websites;
    }

    public function verifiedEmailNormalizer()
    {
        return true; // Linkedin users who have access to OAuth v2 always have a verified email
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data, array(
            'id',
            'firstName',
            'lastName',
            'emailAddress',
            'summary',
            'pictureUrl',
            'publicProfileUrl',
        ));
    }
}
