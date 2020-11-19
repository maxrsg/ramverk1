<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "IP validating API",
            "mount" => "ipApi",
            "handler" => "\Anax\Ip\IpApiController",
        ],
    ]
];
