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

class So_Ftp
{
    /**
     * @var string
     */
    private $_host;
    /**
     * @var int
     */
    private $_port;
    /**
     * @var string
     */
    private $_username;
    /**
     * @var string
     */
    private $_password;

    /**
     * @var string
     */
    private $_path;

    /**
     * @var resource
     */
    private $_connection;

    /**
     * @var bool
     */
    private $_connected = false;

    /**
     * @var string
     */
    protected $_targeturl;

    /**
     * @param string $url
     * @return void
     */
    public function setTargeturl($url)
    {
        $this->_targeturl = $url;
    }

    /**
     * @return string
     */
    public function getTargeturl()
    {
        return $this->_targeturl;
    }


    public function __construct($params) {
        $this->_host = $params['host'];
        $this->_port = $params['port'];
        $this->_username = $params['username'];
        $this->_password = $params['password'];

        $this->_path = $params['path'];
    }


    public function connect() {
        if(false === $this->_connection = ftp_connect($this->_host, $this->_port)) throw new Exception("FTP couldn't connect") ;
        if(false === ftp_login($this->_connection, $this->_username, $this->_password)) throw new Exception("FTP login details wrong") ;

    }

    public function close() {
        ftp_close($this->_connection);
    }

    public function upload($sourceDir, $filename) {
        if(!$this->_connected) $this->connect();

        ftp_chdir($this->_connection, $this->_path);
        ftp_pasv($this->_connection, true);
        ftp_put($this->_connection, $filename, $sourceDir.'/'.$filename, FTP_BINARY);
    }
}