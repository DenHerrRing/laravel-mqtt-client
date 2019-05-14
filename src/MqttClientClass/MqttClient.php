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

/**
 * MqttClient
 */
class MqttClient
{
    protected $client;
    protected $clientId = null;
    protected $host = null;
    protected $username = null;
    protected $certFile = null;
    protected $protocol = null;
    protected $password = null;
    protected $port = null;
    protected $debug = null;
    private $isConnected = false;

    public function __construct()
    {
        $this->host = config('mqttclient.host');
        $this->clientId = config('mqttclient.clientId');
        if ($this->clientId) { // If no ID is set, generate random ID
            $this->clientId = "laravelMqttClient-".rand(1,100)*100;
        }
        $this->username = config('mqttclient.username');
        $this->password = config('mqttclient.password');
        $this->cert_file = config('mqttclient.certfile');
        $this->protocol = config('mqttclient.protocol');
        $this->port = config('mqttclient.port');
        $this->debug = config('mqttclient.debug');
        $this->client = new MqttClientService($this->host, $this->port, $this->protocol);
    }

    /**
     * Connect to Broker
     */
    public function Connect()
    {
        $this->client = new MqttClientService($this->host, $this->port, $this->protocol);
        if ($this->certFile) {
            $this->client->setEncryption($this->certFile);
        }

        if ($this->username && $this->password) {
            $this->client->setAuthentication($this->username, $this->password);
        }
        $this->isConnected = $this->client->sendConnect($this->clientId);
    }

    /**
     * Publish message for given topic
     *
     * @param string $topic
     * @param string $msg
     * @return boolean Returns true if message was send
     */
    public function Publish($topic, $msg)
    {
        if ($this->isConnected) {
            $this->client->sendPublish($topic, $msg);

            return true;
        }
        $this->client->close(); // On Error Close Connection

        return false;
    }

    /**
     * Set will (last message defined by MQTT) to send when connection is lost
     *
     * @param string $willTopic
     * @param string $willMessage
     * @param integer $qos
     * @param boolean $retain
     */
    public function setWill($willTopic, $willMessage, $qos=1, $retain=false)
    {
        $this->client->setWill($willTopic, $willMessage, $qos, $retain);
    }

    /**
     * Disconnect from Broker
     */
    public function Disconnect()
    {
        $this->client->sendDisconnect();
        $this->client->close();
    }

    /**
     * Set Debug of Client
     * @param boolean $debug
     */
    public function debug($debug)
    {
        $this->client->setDebug($debug);
    }

}
