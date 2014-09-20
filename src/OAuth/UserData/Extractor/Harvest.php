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
 * Class Harvest
 * @package OAuth\UserData\Extractor
 */
class Harvest extends LazyExtractor
{
    /**
     * Request constants
     */
    const REQUEST_PROFILE = '/account/who_am_i';

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
            self::FIELD_FIRST_NAME,
            self::FIELD_LAST_NAME,
            self::FIELD_FULL_NAME,
            self::FIELD_IMAGE_URL,
            self::FIELD_EMAIL,
            self::FIELD_EXTRA
        );
    }

    protected function profileLoader()
    {
        return json_decode($this->service->request(self::REQUEST_PROFILE), true);
    }

    protected function uniqueIdNormalizer($data)
    {
        return $data['user']['id'];
    }

    protected function usernameNormalizer($data)
    {
        return isset($data['user']['email']) ? $data['user']['email'] : null;
    }

    protected function fullNameNormalizer($data)
    {
        return $this->firstNameNormalizer($data) . ' ' . $this->lastNameNormalizer($data);
    }

    protected function firstNameNormalizer($data)
    {
        return isset($data['user']['first_name']) ? $data['user']['first_name'] : null;
    }

    protected function lastNameNormalizer($data)
    {
        return isset($data['user']['last_name']) ? $data['user']['last_name'] : null;
    }

    protected function imageUrlNormalizer($data)
    {
        return isset($data['user']['avatar_url']) ? 'https://api.harvestapp.com/' . $data['user']['avatar_url'] : null;
    }

    protected function emailNormalizer($data)
    {
        return isset($data['user']['email']) ? $data['user']['email'] : null;
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data['user'], array(
            'id',
            'first_name',
            'last_name',
            'email',
            'avatar_url'
        ));
    }
}
