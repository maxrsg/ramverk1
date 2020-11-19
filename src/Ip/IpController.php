<?php

namespace Anax\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IpController implements ContainerInjectableInterface
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
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction()
    {
        $page = $this->di->get("page");
        $page->add('anax/Ip/validate');

        return $page->render(["title" => "IP Validator"]);
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexActionPost() : object
    {
        $page = $this->di->get("page");
        $ip = $this->di->request->getPost('ip') ?? "";

        error_reporting(0);
        if (gethostbyaddr($ip)) {
            $host = gethostbyaddr($ip);
        } else {
            $host = "No hostname found";
        }
        error_reporting(1);

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $type = "IPv4";
        } else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $type = "IPv6";
        } else {
            $type = "Invalid IP";
        }

        $data = [
            "ip" => $ip,
            "type" => $type,
            "hostname" => $host
        ];

        $page->add("anax/Ip/validate", $data);
        return $page->render([
            "title" => "Ip validator"
        ]);
    }
}
