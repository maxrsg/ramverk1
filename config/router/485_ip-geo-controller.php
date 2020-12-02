<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geotagging IP",
            "mount" => "ipGeo",
            "handler" => "\Anax\Geo\IpGeoController",
        ],
    ]
];
