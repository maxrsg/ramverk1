<?php

namespace Anax\Geo;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class GeoModelTest extends TestCase
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
     * Test ip validation
     */
    public function testValidateIp()
    {
        // Setup of the model
        $model = new GeoModel(ANAX_INSTALL_PATH."/config/api/ipstack.txt");
        $ip = "194.47.150.9";
        // validate the ip
        $res = $model->validateIp($ip);
        $this->assertNotFalse($res);
    }



    /**
     * Test api call
     */
    public function testApiCall()
    {
        // Setup of the model
        $model = new GeoModel(ANAX_INSTALL_PATH."/config/api/ipstack.txt");
        $ip = "194.47.150.9";

        $model->getDataFromApi($ip);
        $res = $model->getData();

        $this->assertIsObject($res);
    }
}
