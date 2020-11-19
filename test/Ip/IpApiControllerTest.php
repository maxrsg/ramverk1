<?php

namespace Anax\Ip;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class IpApiControllerTest extends TestCase
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
    public function testIndexAction()
    {
        // Setup of the controller
        $controller = new \Anax\Ip\IpApiController();
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
        $controller = new \Anax\Ip\IpApiController();
        $controller->setDI($this->di);

        // test valid IPv4
        $request = $this->di->get("request");
        $request->setPost("ip", "194.47.150.9");
        $res = $controller->indexActionPost();
        $expected = [
            'ip' => "194.47.150.9",
            'type' => "IPv4",
            'hostname' =>"dbwebb.tekproj.bth.se"
        ];
        $this->assertEquals($expected, $res[0]);

        // test valid IPv6
        $request = $this->di->get("request");
        $request->setPost("ip", "2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $res = $controller->indexActionPost();
        $expected = [
            'ip' => "2001:0db8:85a3:0000:0000:8a2e:0370:7334",
            'type' => "IPv6",
            'hostname' =>"2001:0db8:85a3:0000:0000:8a2e:0370:7334"
        ];
        $this->assertEquals($expected, $res[0]);

        // test invalid IP
        $request->setPost("ip", "invalid ip");
        $res = $controller->indexActionPost();
        $expected = [
            'ip' => "invalid ip",
            'type' => "Invalid IP",
            'hostname' =>"No hostname found"
        ];
        $this->assertEquals($expected, $res[0]);

        // test special case
        $request->setPost("ip", "B");
        $res = $controller->indexActionPost();
        $expected = [
            'ip' => "No IP address found",
            'type' => "Invalid IP",
            'hostname' =>"No hostname found"
        ];
        $this->assertEquals($expected, $res[0]);
    }
}
