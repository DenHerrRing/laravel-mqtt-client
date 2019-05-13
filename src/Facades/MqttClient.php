<?php

namespace DenHerrRing\MqttClient\Facades;

use Illuminate\Support\Facades\Facade;

class MqttClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MqttClient';
    }
}
