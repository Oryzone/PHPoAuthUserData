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
use OAuth\UserData\Utils\StringUtils;

/**
 * Class Facebook
 * @package OAuth\UserData\Extractor
 */
class Facebook extends LazyExtractor
{

    /**
     * Request contants
     */
    const REQUEST_PROFILE = '/me';
    const REQUEST_IMAGE = '/me/picture?type=large&redirect=false';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct($this->getLoadersMap(), $this->getNormalizersMap(), $this->getAllFields());
    }

    protected function getLoadersMap()
    {
        return array_merge($this->getDefaultLoadersMap(), array(
            self::FIELD_IMAGE_URL => 'image',
        ));
    }

    public function getNormalizersMap()
    {
        return array_merge($this->getDefaultNormalizersMap(), array(
            self::FIELD_IMAGE_URL => null,
        ));
    }

    protected function profileLoader()
    {
        return ArrayUtils::objectToArray(json_decode($this->service->request(self::REQUEST_PROFILE)));
    }

    protected function imageLoader()
    {
        $rawPicture = json_decode($this->service->request(self::REQUEST_IMAGE));
        if (isset($rawPicture->data) && isset($rawPicture->data->url)) {
            return $rawPicture->data->url;
        }

        return null;
    }

    protected function uniqueIdNormalizer($data)
    {
        return $data['id'];
    }

    protected function usernameNormalizer($data)
    {
        return isset($data['username']) ? $data['username'] : null;
    }

    protected function firstNameNormalizer($data)
    {
        return isset($data['first_name']) ? $data['first_name'] : null;
    }

    protected function lastNameNormalizer($data)
    {
        return isset($data['last_name']) ? $data['last_name'] : null;
    }

    protected function fullNameNormalizer($data)
    {
        return isset($data['name']) ? $data['name'] : null;
    }

    protected function emailNormalizer($data)
    {
        return isset($data['email']) ? $data['email'] : null;
    }

    protected function descriptionNormalizer($data)
    {
        return isset($data['bio']) ? $data['bio'] : null;
    }

    protected function profileUrlNormalizer($data)
    {
        return isset($data['link']) ? $data['link'] : null;
    }

    protected function locationNormalizer($data)
    {
        return isset($data['location']['name']) ? $data['location']['name'] : null;
    }

    protected function websitesNormalizer($data)
    {
        return isset($data['website']) ? StringUtils::extractUrls($data['website']) : array();
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data, array(
            'id',
            'username',
            'first_name',
            'last_name',
            'name',
            'email',
            'bio',
            'link',
            'location',
            'website'
        ));
    }
}
