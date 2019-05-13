<?php
namespace DenHerrRing\MqttClient;

use Illuminate\Support\ServiceProvider;
use DenHerrRing\MqttClient\MqttClientClass\MqttClient;

class MqttClientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/config/mqttclient.php','mqttclient');
        $this->publishes([
            __DIR__.'/config/mqttclient.php' => config_path('mqttclient.php'),
        ]);
    }
    public function register()
    {
        $this->app->singleton('MqttClient',function (){
            return new MqttClient();
        });
    }
    /**
     * @return array
     */
    public function provides()
    {
        return array('MqttClient');
    }
}
