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
     * The hostname of the FTP server
     *
     * @var string
     */
    protected $_host;

    /**
     * The port number of the FTP server
     * @var int
     */
    protected $_port;

    /**
     * The username for logging in
     *
     * @var string
     */
    protected $_username;

    /**
     * @var string
     */
    protected $_password;

    /**
     * The path on the remote server where the files need to be stored
     * @var string
     */
    protected $_path;

    /**
     * A php ftp resource
     *
     * @var resource
     */
    protected $_connection;

    /**
     * Indicates whether the ftp_connect has been invoked
     *
     * @var bool
     */
    protected $_connected = false;

    /**
     * The url prefix that can be used to retrieve the uploaded files with http
     * @var string
     */
    protected $_targeturl;


    /**
     * Constructor
     *
     * @param array $params
     * @return void
     */
    public function __construct($params) {
        $this->_host = $params['host'];
        $this->_port = $params['port'];
        $this->_username = $params['username'];
        $this->_password = $params['password'];

        $this->_path = $params['path'];
    }


    /**
     * Set the url prefix that can be used to retrieve the uploaded files with http
     *
     * @param string $url
     * @return void
     */
    public function setTargeturl($url)
    {
        $this->_targeturl = $url;
    }

    /**
     * Get the url prefix that can be used to retrieve the uploaded files with http
     * @return string
     */
    public function getTargeturl()
    {
        return $this->_targeturl;
    }


    /**
     * Connect to the ftp server and test credentials
     *
     * @return void
     */
    public function connect() {
        if(false === $this->_connection = ftp_connect($this->_host, $this->_port))
            throw new Exception("FTP couldn't connect") ;
        if(false === ftp_login($this->_connection, $this->_username, $this->_password))
            throw new Exception("FTP login details wrong") ;
        $this->_connected = true;
    }

    /**
     * Close the connection and free the ftp resource
     *
     * @return void
     */
    public function close() {
        ftp_close($this->_connection);
        $this->_connected = false;
    }

    /**
     * Connect if not done yet, and then transfer the file from sourcedir to the ftp server
     *
     * @param string $sourceDir The local directory where the file can be found
     * @param string $filename The name of the file to be uploaded (without directory)
     * @return void
     */
    public function upload($sourceDir, $filename) {
        if(!$this->_connected) $this->connect();

        if(!ftp_chdir($this->_connection, $this->_path))
            throw new Exception("FTP target directory does not exist");
        if(!ftp_pasv($this->_connection, true))
            throw new Exception("FTP Passive mode not supported");
        if(!ftp_put($this->_connection, $filename, $sourceDir.'/'.$filename, FTP_BINARY))
            throw new Exception("FTP Upload failed");
    }
}