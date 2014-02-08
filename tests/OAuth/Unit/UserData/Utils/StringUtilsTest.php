<?php

namespace OAuth\Unit\UserData\Utils;

use OAuth\UserData\Utils\StringUtils;

class StringUtilsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers OAuth\UserData\Utils\StringUtils::extractUrls
     */
    public function testExtractUrls()
    {
        $string = "Lorem ipsum http://example.com dolor sit http://example2.com amet http://example3.com";

        $expected = array(
            'http://example.com',
            'http://example2.com',
            'http://example3.com'
        );

        $actual = StringUtils::extractUrls($string);

        $this->assertEquals($expected, $actual);
    }
}
