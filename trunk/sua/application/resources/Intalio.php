<?php
class So_Resource_Intalio extends Zend_Application_Resource_ResourceAbstract
{
    private $_endpoint;
    private $_key;
    private $_keyTimeout;

    private $_intalio;

    public function setEndpoint($endpoint)
    {
        $this->_endpoint = $endpoint;
    }

    public function setKey($key)
    {
        $this->_key = $key;
    }

    public function setKeyTimeout($keyTimeout)
    {
        $this->_keyTimeout = $keyTimeout;
    }

    private function getIntalio()
    {
        if(null === $this->_intalio) {
            $this->_intalio = new So_Intalio($this->_key, $this->_endpoint, $this->_keyTimeout);
        }
        return $this->_intalio;
    }
    public function init()
    {
        return $this->getIntalio();
    }
}