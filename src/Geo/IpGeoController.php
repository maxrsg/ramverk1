<?php

namespace Anax\Geo;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IpGeoController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }


    public function indexAction()
    {
        $userIp = $this->di->request->getServer("REMOTE_ADDR");

        $data = [
            "userIP" => $userIp
        ];

        $page = $this->di->get("page");
        $page->add('anax/Ip/geo', $data);

        return $page->render([
            "title" => "IP Geotagging"
        ]);
    }




    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexActionPost()
    {
        $model = new GeoModel(ANAX_INSTALL_PATH."/config/api/ipstack.txt");
        $ipAddr = $this->di->request->getPost('ip') ?? "";

        if ($model->validateIp($ipAddr)) {
            $model->getDataFromApi($ipAddr);
            $res = $model->getData();
        } else {
            $res = "Invalid IP";
        }

        $userIp = $this->di->request->getServer("REMOTE_ADDR");

        $data = [
            "result" => $res,
            "userIP" => $userIp
        ];

        $page = $this->di->get("page");
        $page->add('anax/Ip/geo', $data);

        return $page->render([
            "title" => "IP Geotagging"
        ]);
    }
}
