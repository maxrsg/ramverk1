<?php

namespace Anax\Geo;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class GeoApiController implements ContainerInjectableInterface
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


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexActionGet() : array
    {
        // Deal with the action and return a response.
        $json = [
            "message" => __METHOD__ . ", \$db is {$this->db}",
        ];
        return [$json];
    }



    /**
     * This is the post method action
     *
     * @return array
     */
    public function indexActionPost() : array
    {
        try {
            $body = $this->di->get("request")->getBodyAsJson();
        } catch (\Exception $e) {
            $body = "Body is missing!";
        }

        if ($this->di->request->getPost('ip')) {
            $ip = $this->di->request->getPost('ip');
        } else if ($body['ip']) {
            $ip = $body['ip'];
        }

        $model = new GeoModel(ANAX_INSTALL_PATH."/config/api/ipstack.txt");
        // $ip = $this->di->request->getPost('ip') ?? "";

        if($model->validateIp($ip)) {
            $model->getDataFromApi($ip);
            $res = $model->getData();
            $json = [
                "IP" => $res->ip,
                "Type" => $res->type,
                "Continent" => $res->continent_name,
                "Country" =>$res->country_name,
                "Region" => $res->region_name,
                "City" => $res->city,
                "Zip" => $res->zip,
                "Latitude" => $res->latitude,
                "Longitude" => $res->longitude
            ];
        } else {
            $json = [
                "error" => "Invalid IP"
            ];
        }

        return [$json];
    }
}
