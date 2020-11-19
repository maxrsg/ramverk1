<?php

namespace Anax\Ip;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class IpControllerTest extends TestCase
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
        $controller = new \Anax\Ip\IpController();
        $controller->initialize();
        $controller->setDI($this->di);

        // Test controller action
        $res = $controller->indexAction();
        $this->assertInstanceOf("\Anax\Response\ResponseUtility", $res);
    }



    /**
     * Test the post
     */
    public function testIndexActionPost()
    {
        // Setup of the controller
        $controller = new \Anax\Ip\IpController();
        $controller->setDI($this->di);

        //test IPv4
        $request = $this->di->get("request");
        $request->setPost("ip", "194.47.150.9");
        $res = $controller->indexActionPost();
        $this->assertInstanceOf("\Anax\Response\ResponseUtility", $res);

        //test invalid IP
        $request->setPost("ip", "invalid ip");
        $res = $controller->indexActionPost();
        $this->assertInstanceOf("\Anax\Response\ResponseUtility", $res);

        //test valid IPv6
        $request->setPost("ip", "2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $res = $controller->indexActionPost();
        $this->assertInstanceOf("\Anax\Response\ResponseUtility", $res);
    }
}
