<?php

class So_Youtube
{
    private $_httpClientParams;

    private $_devKey;
    private $_appId;
    private $_clientId;

    private $_yt;

    public function __construct($httpClientParams, $devKey, $appId, $clientId) 
    {
        $this->_httpClientParams = $httpClientParams;
        $this->_devKey = $devKey;
        $this->_appId = $appId;
        $this->_clientId = $clientId;
    }

    public function getYouTubeInstance() 
    {
        if(null === $this->_yt) {
            $this->_yt = new Zend_Gdata_YouTube(
                $this->getHttpClient(),
                $this->_appId,
                $this->_clientId,
                $this->_devKey
            );
        }

        return $this->_yt;
    }

    private function getHttpClient() 
    {
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
            $this->_httpClientParams['email'],
            $this->_httpClientParams['password'],
			"youtube"	
		);

		return $httpClient;
    }



}