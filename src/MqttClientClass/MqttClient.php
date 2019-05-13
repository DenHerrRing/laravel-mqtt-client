<?php


namespace DenHerrRing\MqttClient\MqttClientClass;

/*
	Licence
	Copyright (c) 2019 Dennis Hering
	dennis@hering.me
	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:
	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.

*/


class MqttClient
{
    protected $client;
    protected $clientId;
    protected $host = null;
    protected $username = null;
    protected $cert_file = null;
    protected $password = null;
    protected $port = null;
    protected $debug = null;

    public function __construct()
    {
        $this->host = config('mqtt.host');
        $this->clientId = config('mqtt.clientId');
        $this->username = config('mqtt.username');
        $this->password = config('mqtt.password');
        $this->cert_file = config('mqtt.certfile');
        $this->port = config('mqtt.port');
        $this->debug = config('mqtt.debug');

    }


    public function ConnectAndPublish($topic, $msg, $will = NULL)
    {
        if ($this->clientId === NULL) {
            $clientId = "mqttClient-" . rand(0, 100);
        } else {
            $clientId = $this->clientId;
        }

        $client = new MqttClientService($this->host, $this->port, $clientId, $this->debug, $this->cert_file);

        if ($client->connect(true, $will, $this->username, $this->password)) {
            $client->publish($topic, $msg);
            $client->close();

            return true;
        }

        return false;

    }


}
