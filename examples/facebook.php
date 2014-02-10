<?php

/**
 * Example of retrieving an authentication token of the Facebook service
 * and extract user data. Based on the Lusitanian/PHPoAuthLib facebook example that can be
 * found here: https://github.com/Lusitanian/PHPoAuthLib/blob/master/examples/facebook.php
 */

use OAuth\OAuth2\Service\Facebook;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;
use OAuth\UserData\ExtractorFactory;

/**
 * Bootstrap the example
 */
require_once __DIR__ . '/bootstrap.php';

// Session storage
$storage = new Session();

// Setup the credentials for the requests
$credentials = new Credentials(
    $servicesCredentials['facebook']['key'],
    $servicesCredentials['facebook']['secret'],
    $currentUri->getAbsoluteUri()
);

// Instantiate the Facebook service using the credentials, http client and storage mechanism for the token
/** @var $facebookService Facebook */
$facebookService = $serviceFactory->createService('facebook', $credentials, $storage, array());

if (!empty($_GET['code'])) {
    // This was a callback request from facebook, get the token
    $token = $facebookService->requestAccessToken($_GET['code']);

    // Send a request with it
    $result = json_decode($facebookService->request('/me'), true);

    // Instantiate the facebook extractor
    $extractorFactory = new ExtractorFactory();
    $facebookExtractor = $extractorFactory->get($facebookService);

    // Show some of the resultant data using the extractor
    echo 'Your unique facebook user id is: ' . $facebookExtractor->getUniqueId() .
            ' and your name is ' . $facebookExtractor->getFullName();

} elseif (!empty($_GET['go']) && $_GET['go'] === 'go') {
    $url = $facebookService->getAuthorizationUri();
    header('Location: ' . $url);
} else {
    $url = $currentUri->getRelativeUri() . '?go=go';
    echo "<a href='$url'>Login with Facebook!</a>";
}
