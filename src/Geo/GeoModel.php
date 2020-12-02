<?php

namespace Anax\Geo;


class GeoModel
{
    protected $apiKey;
    private $data;

    public function __construct($path)
    { //ANAX_INSTALL_PATH."/config/api/ipstack.txt"
        $this->apiKey = file_get_contents($path);
    }



    public function getDataFromApi($ip) {
        $url = "http://api.ipstack.com/" . $ip . "?access_key=" . $this->apiKey;
        $data = file_get_contents($url);
        $this->data = json_decode($data);
    }



    public function getData() {
        return $this->data;
    }



    public function validateIp($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }
}
