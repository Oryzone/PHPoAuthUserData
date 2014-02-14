<?php

/*
 * This file is part of the Oryzone PHPoAuthUserData package <https://github.com/Oryzone/PHPoAuthUserData>.
 *
 * (c) Oryzone, developed by Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OAuth\Unit\UserData\Extractor;

use OAuth\UserData\Extractor\GitHub as GitHubExtractor;
use OAuth\OAuth2\Service\GitHub as GitHubService;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-02-08 at 00:52:53.
 */
class GitHubTest extends \PHPUnit_Framework_TestCase
{
    const PROFILE_RESPONSE =
        '{
          "login": "octocat",
          "id": 123,
          "avatar_url": "https://github.com/images/error/octocat_happy.gif",
          "gravatar_id": "somehexcode",
          "url": "https://api.github.com/users/octocat",
          "html_url": "https://github.com/octocat",
          "followers_url": "https://api.github.com/users/octocat/followers",
          "following_url": "https://api.github.com/users/octocat/following{/other_user}",
          "gists_url": "https://api.github.com/users/octocat/gists{/gist_id}",
          "starred_url": "https://api.github.com/users/octocat/starred{/owner}{/repo}",
          "subscriptions_url": "https://api.github.com/users/octocat/subscriptions",
          "organizations_url": "https://api.github.com/users/octocat/orgs",
          "repos_url": "https://api.github.com/users/octocat/repos",
          "events_url": "https://api.github.com/users/octocat/events{/privacy}",
          "received_events_url": "https://api.github.com/users/octocat/received_events",
          "type": "User",
          "site_admin": false,
          "name": "monalisa octocat",
          "company": "GitHub",
          "blog": "https://github.com/blog",
          "location": "San Francisco",
          "email": "octocat@github.com",
          "hireable": false,
          "bio": "There once was...",
          "public_repos": 2,
          "public_gists": 1,
          "followers": 20,
          "following": 0,
          "created_at": "2008-01-14T04:33:35Z",
          "updated_at": "2008-01-14T04:33:35Z",
          "total_private_repos": 100,
          "owned_private_repos": 100,
          "private_gists": 81,
          "disk_usage": 10000,
          "collaborators": 8,
          "plan": {
            "name": "Medium",
            "space": 400,
            "collaborators": 10,
            "private_repos": 20
          }
        }';

    const EMAIL_RESPONSE_PRIMARY_AND_VERIFIED =
        '[
          {
            "email": "one@example.com",
            "verified": false,
            "primary": false
          },
          {
            "email": "two@example.com",
            "verified": true,
            "primary": false
          },
          {
            "email": "three@example.com",
            "verified": true,
            "primary": true
          }
        ]';

    const EMAIL_RESPONSE_PRIMARY_BUT_NOT_VERIFIED =
        '[
          {
            "email": "one@example.com",
            "verified": false,
            "primary": false
          }
        ]';

    /**
     * @var GitHubExtractor
     */
    protected $extractor;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->extractor = new GitHubExtractor();
        $service = $this->getMockBuilder('\\OAuth\\OAuth2\\Service\\GitHub')
            ->disableOriginalConstructor()
            ->getMock();
        $service->expects($this->any())
            ->method('request')
            ->with(GitHubExtractor::REQUEST_PROFILE)
            ->will($this->returnValue(GitHubTest::PROFILE_RESPONSE));

        /**
         * @var \OAuth\Common\Service\ServiceInterface $service
         */
        $this->extractor->setService($service);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testDoesNotSupportWebsites()
    {
        $this->assertFalse($this->extractor->supportsWebsites());
        $this->assertNull($this->extractor->getWebsites());
    }

    public function testGetUniqueId()
    {
        $this->assertEquals(123, $this->extractor->getUniqueId());
    }

    public function testGetUsername()
    {
        $this->assertEquals('octocat', $this->extractor->getUsername());
    }

    public function testGetFistName()
    {
        $this->assertEquals('monalisa', $this->extractor->getFirstName());
    }

    public function testGetLastName()
    {
        $this->assertEquals('octocat', $this->extractor->getLastName());
    }

    public function testGetFullName()
    {
        $this->assertEquals('monalisa octocat', $this->extractor->getFullName());
    }

    public function testGetEmailWithPrimaryAndVerifiedAvailable()
    {
        $this->extractor->setService($this->getEmailTestMock(GitHubTest::EMAIL_RESPONSE_PRIMARY_AND_VERIFIED));

        $this->assertEquals("three@example.com", $this->extractor->getEmail());
    }

    public function testGetEmailWithPrimaryButNotVerifiedAvailable()
    {
        $this->extractor->setService($this->getEmailTestMock(GitHubTest::EMAIL_RESPONSE_PRIMARY_BUT_NOT_VERIFIED));

        $this->assertEquals("one@example.com", $this->extractor->getEmail());
    }

    public function testGetLocation()
    {
        $this->assertEquals('San Francisco', $this->extractor->getLocation());
    }

    public function testGetDescription()
    {
        $this->assertEquals('There once was...', $this->extractor->getDescription());
    }

    public function testGetImageUrl()
    {
        $this->assertEquals('https://github.com/images/error/octocat_happy.gif', $this->extractor->getImageUrl());
    }

    public function testGetProfileUrl()
    {
        $this->assertEquals('https://github.com/octocat', $this->extractor->getProfileUrl());
    }

    public function testIsEmailVerifiedIfVerified()
    {
        $this->extractor->setService($this->getEmailTestMock(GitHubTest::EMAIL_RESPONSE_PRIMARY_AND_VERIFIED));

        $this->assertEquals(true, $this->extractor->isEmailVerified());
    }

    public function testIsEmailVerifiedIfNotVerified()
    {
        $this->extractor->setService($this->getEmailTestMock(GitHubTest::EMAIL_RESPONSE_PRIMARY_BUT_NOT_VERIFIED));

        $this->assertEquals(false, $this->extractor->isEmailVerified());
    }

    public function testGetExtra()
    {
        $extra = $this->extractor->getExtras();

        $this->assertArrayHasKey('gravatar_id', $extra);
        $this->assertArrayHasKey('disk_usage', $extra);
        $this->assertArrayHasKey('type', $extra);

        $this->assertArrayNotHasKey('id', $extra);
        $this->assertArrayNotHasKey('login', $extra);
        $this->assertArrayNotHasKey('name', $extra);
        $this->assertArrayNotHasKey('location', $extra);
        $this->assertArrayNotHasKey('bio', $extra);
        $this->assertArrayNotHasKey('avatar_url', $extra);
        $this->assertArrayNotHasKey('html_url', $extra);
    }

    /**
     * @return \OAuth\Common\Service\ServiceInterface
     */
    private function getEmailTestMock($returnValue)
    {
        $service = $this->getMockBuilder('\\OAuth\\OAuth2\\Service\\GitHub')
            ->disableOriginalConstructor()
            ->getMock();
        $service->expects($this->any())
            ->method('request')
            ->with(GitHubExtractor::REQUEST_EMAIL, 'GET', array(), array('Accept' => 'application/vnd.github.v3'))
            ->will($this->returnValue($returnValue));

        return $service;
    }
}
