<?php

return [
    'host' => env('mqtt_host', '127.0.0.1'),
    'clientId' => env('mqtt_clientId', null),
    'password' => env('mqtt_password', ''),
    'username' => env('mqtt_username', ''),
    'certfile' => env('mqtt_cert_file', ''),
    'port' => env('mqtt_port', '1883'),
    'debug' => env('mqtt_debug', false) //Optional Parameter to enable debugging set it to True
];
