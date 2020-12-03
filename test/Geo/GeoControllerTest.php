<?php

namespace Anax\Geo;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class GeoControllerTest extends TestCase
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
        $controller = new \Anax\Geo\IpGeoController();
        $controller->setDI($this->di);
        $this->di->get("request");

        //initialize controller
        $controller->initialize();

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
        $controller = new \Anax\Geo\IpGeoController();
        $controller->setDI($this->di);
        $request = $this->di->get("request");

        //test valid ip
        $request->setPost("ip", "194.47.150.9");
        $res = $controller->indexActionPost();
        $this->assertInstanceOf("\Anax\Response\ResponseUtility", $res);

        //test invalid ip
        $request->setPost("ip", "abc123");
        $res = $controller->indexActionPost();
        $this->assertInstanceOf("\Anax\Response\ResponseUtility", $res);
    }
}
