<?php

namespace Anax\Geo;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class GeoApiControllerTest extends TestCase
{
    // Create the di container.
    protected $di;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $this->di = $di;
    }



    /**
     * Test index
     */
    public function testIndexActionGet()
    {
        // Setup of the controller
        $controller = new \Anax\Geo\GeoApiController();
        $controller->initialize();
        $controller->setDI($this->di);

        // Test controller action
        $res = $controller->indexActionGet();
        $this->assertTrue(is_array($res));
    }



    /**
     * Test post
     */
    public function testIndexActionPost()
    {
        // Setup of the controller
        $controller = new \Anax\Geo\GeoApiController();
        $controller->setDI($this->di);

        // test valid IPv4
        $request = $this->di->get("request");
        $request->setPost("ip", "194.47.150.9");
        $res = $controller->indexActionPost();
        $expected = [
            "IP" => "194.47.150.9",
            "Type" => "ipv4",
            "Continent" => "Europe",
            "Country" => "Sweden",
            "Region" => "Blekinge",
            "City" => "Karlskrona",
            "Zip" => "371 00",
            "Latitude" => 56.16122055053711,
            "Longitude" => 15.586899757385254
        ];
        $this->assertEquals($expected, $res[0]);

        // test invalid IP
        $request->setPost("ip", "invalid ip");
        $res = $controller->indexActionPost();
        $expected = [
            "error" => "Invalid IP",
        ];
        $this->assertEquals($expected, $res[0]);
    }
}
