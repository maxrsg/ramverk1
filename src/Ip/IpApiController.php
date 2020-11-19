<?php

namespace Anax\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IpApiController implements ContainerInjectableInterface
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


        error_reporting(0);
        if ($this->di->request->getPost('ip')) {
            $ip = $this->di->request->getPost('ip');
        } else if ($body['ip']) {
            $ip = $body['ip'];
        }
        if (gethostbyaddr($ip)) {
            $host = gethostbyaddr($ip);
        } else {
            $host = "No hostname found";
        }
        error_reporting(1);


        if ($ip == "B") {
            $ip = "No IP address found";
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $type = "IPv4";
        } else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $type = "IPv6";
        } else {
            $type = "Invalid IP";
        }

        $json = [
            "ip" => $ip,
            "type" => $type,
            "hostname" => $host
        ];

        return [$json];
    }
}
