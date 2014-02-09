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
 * Class LazyExtractor
 * @package OAuth\UserData\Extractor
 */
class LazyExtractor extends Extractor
{
    /**
     * @var array $loadersMap
     */
    protected $loadersMap;

    /**
     * @var array $normalizersMap
     */
    protected $normalizersMap;

    /**
     * @var array $loadersResults
     */
    protected $loadersResults;

    /**
     * Constructor
     *
     * @param array    $loadersMap
     * @param array    $normalizersMap
     * @param string[] $supports
     * @param array    $fields
     */
    public function __construct(
        $loadersMap = array(),
        $normalizersMap = array(),
        $supports = array(),
        $fields = array()
    ) {
        parent::__construct($supports, $fields);

        $this->loadersMap = $loadersMap;
        $this->normalizersMap = $normalizersMap;

        $this->loadersResults = array();
    }

    /**
     * {@inheritDoc}
     * @param string $field
     */
    public function getField($field)
    {
        if (!$this->isFieldSupported($field)) {
            return null;
        }

        if (!$this->hasLoadedField($field)) {
            $loaderData = $this->getLoaderData($field);
            if (isset($this->normalizersMap[$field])) {
                $normalizerName = $this->normalizersMap[$field];
                $normalizerFunction = sprintf('%sNormalizer', $normalizerName);
                $this->fields[$field] = $this->$normalizerFunction($loaderData);
            } else {
                $this->fields[$field] = $loaderData;
            }
        }

        return parent::getField($field);
    }

    /**
     * Check if already loaded a given field
     *
     * @param  string $field
     * @return bool
     */
    protected function hasLoadedField($field)
    {
        return array_key_exists($field, $this->fields);
    }

    /**
     * Get data from a loader.
     * A loader is a function who is delegated to fetch a request to get the raw data
     *
     * @param  string $field
     * @return mixed
     */
    protected function getLoaderData($field)
    {
        $loaderName = $this->loadersMap[$field];
        $loaderFunction = sprintf('%sLoader', $loaderName);
        if (!isset($this->loadersResults[$loaderName])) {
            $this->loadersResults[$loaderName] = $this->$loaderFunction();
        }

        return $this->loadersResults[$loaderName];
    }

    /**
     * Get a default map of loaders
     *
     * @return array
     */
    protected static function getDefaultLoadersMap()
    {
        return array(
            self::FIELD_UNIQUE_ID       =>   'profile',
            self::FIELD_USERNAME        =>   'profile',
            self::FIELD_FIRST_NAME      =>   'profile',
            self::FIELD_LAST_NAME       =>   'profile',
            self::FIELD_FULL_NAME       =>   'profile',
            self::FIELD_EMAIL           =>   'profile',
            self::FIELD_DESCRIPTION     =>   'profile',
            self::FIELD_LOCATION        =>   'profile',
            self::FIELD_PROFILE_URL     =>   'profile',
            self::FIELD_IMAGE_URL       =>   'profile',
            self::FIELD_WEBSITES        =>   'profile',
            self::FIELD_VERIFIED_EMAIL  =>   'profile',
            self::FIELD_EXTRA           =>   'profile',
        );
    }

    /**
     * Get a default normalizers map
     *
     * @return array
     */
    protected static function getDefaultNormalizersMap()
    {
        return array(
            self::FIELD_UNIQUE_ID       =>   self::FIELD_UNIQUE_ID,
            self::FIELD_USERNAME        =>   self::FIELD_USERNAME,
            self::FIELD_FIRST_NAME      =>   self::FIELD_FIRST_NAME,
            self::FIELD_LAST_NAME       =>   self::FIELD_LAST_NAME,
            self::FIELD_FULL_NAME       =>   self::FIELD_FULL_NAME,
            self::FIELD_EMAIL           =>   self::FIELD_EMAIL,
            self::FIELD_DESCRIPTION     =>   self::FIELD_DESCRIPTION,
            self::FIELD_LOCATION        =>   self::FIELD_LOCATION,
            self::FIELD_PROFILE_URL     =>   self::FIELD_PROFILE_URL,
            self::FIELD_IMAGE_URL       =>   self::FIELD_IMAGE_URL,
            self::FIELD_WEBSITES        =>   self::FIELD_WEBSITES,
            self::FIELD_VERIFIED_EMAIL  =>   self::FIELD_VERIFIED_EMAIL,
            self::FIELD_EXTRA           =>   self::FIELD_EXTRA,
        );
    }
}
