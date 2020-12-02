<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geotagging IP API",
            "mount" => "geoApi",
            "handler" => "\Anax\Geo\GeoApiController",
        ],
    ]
];
