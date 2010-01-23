<?php
/**
 * SUA
 *
 * LICENSE
 *
 * This file is part of Switched On Upload Agent (SUA).
 *
 * SUA is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SUA is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SUA.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright (c) 2009-2010 Switched On (International)
 * @author Peter Smit, (peter AT smitmail DOT eu)
 *
 */

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