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

class So_Resource_Youtube extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var string
     */
    private $_devKey;
    /**
     * @var string
     */
    private $_appId;
    /**
     * @var string
     */
    private $_clientId;

    /**
     * @var null|Zend_Gdata_YouTube
     */
    private $_yt = null;


    /**
     * @param string $devKey
     * @return void
     */
    public function setDeveloperKey($devKey)
    {
        $this->_devKey = $devKey;
    }

    /**
     * @param string $appId
     * @return void
     */
    public function setApplicationId($appId)
    {
        $this->_appId = $appId;
    }

    /**
     * @param string $clientId
     * @return void
     */
    public function setClientId($clientId)
    {
        $this->_clientId = $clientId;
    }

    /**
     *
     * @return Zend_Gdata_YouTube
     */
    public function getYoutube() {
        if(null === $this->_yt) {
            $this->_yt = new Zend_Gdata_YouTube(
                $this->getHttpClient(),
                $this->_options['applicationId'],
                $this->_options['clientId'],
                $this->_options['developerKey']
            );
        }
        return $this->_yt;
    }

    /**
     * @return Zend_Gdata_HttpClient
     */
    private function getHttpClient()
    {
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
            $username = $this->_options['httpClient']['username'],
            $password = $this->_options['httpClient']['password'],
            $service = 'youtube',
            $client = null,
            $source = $this->_options['httpClient']['source'], // a short string identifying your application
            $loginToken = null,
            $loginCaptcha = null,
            $this->_options['httpClient']['authenticationURL']
        );
        return $httpClient;
    }

    /**
     * @return So_Resource_Youtube
     */
    public function init()
    {
        return $this;
    }
}