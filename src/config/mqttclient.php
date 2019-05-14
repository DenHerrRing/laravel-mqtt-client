<?php

return [
    'host' => env('mqttclient_host', '127.0.0.1'),
    'clientId' => env('mqttclient_clientId', null),
    'password' => env('mqttclient_password', null),
    'username' => env('mqttclient_username', null),
    'certfile' => env('mqttclient_cert_file', null),
    'protocol' => env('mqttclient_protocol', 'tcp'),
    'port' => env('mqttclient_port', '1883'),
    'debug' => env('mqttclient_debug', false) //Optional Parameter to enable debugging set it to True
];
