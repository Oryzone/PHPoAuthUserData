<?php

/*
 * This file is part of the Oryzone PHPoAuthUserData package <https://github.com/Oryzone/PHPoAuthUserData>.
 *
 * (c) Oryzone, developed by Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OAuth\UserData\Exception;

/**
 * Class InvalidExtractorException
 * @package OAuth\UserData\Exception
 */
class InvalidExtractorException extends \Exception implements Exception
{
    /**
     * @var string $serviceName
     */
    protected $serviceName;

    /**
     * Constructor
     *
     * @param string $serviceName
     */
    public function __construct($serviceName)
    {
        $this->serviceName = $serviceName;
        $message = sprintf('The service "%s" is not associated to an object implementing OAuth\UserData\Extractor\ExtractorInterface', $serviceName);
        parent::__construct($message);
    }

    /**
     * Get the service name
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

}
