<?php

namespace Picqer\BolPlazaClient\Request;

class CurlHttpRequest
{
    protected $ch = null;

    public function __construct($url)
    {
        $this->ch = curl_init($url);
    }

    public function setOption($option, $value)
    {
        curl_setopt($this->ch, $option, $value);
    }

    public function execute()
    {
        return curl_exec($this->ch);
    }

    public function getInfo($option = null)
    {
        if($opt) {
            return curl_getinfo($this->ch, $option);
        } else {
            return curl_getinfo($this->ch);
        }
    }

    public function close()
    {
        curl_close($this->ch);
    }

    public function getErrorNumber()
    {
        return curl_errno($this->ch);
    }
}
