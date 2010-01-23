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

class So_Intalio
{
    /**
     * @var string
     */
    private $_endpoint;
    /**
     * @var string
     */
    private $_key;
    /**
     * @var int
     */
    private $_keyTimeout;

    /**
     * @var string
     */
    const INCOMING_STRING = "INTALIOTOSUA";
    /**
     * @var string
     */
    const OUTGOING_STRING = "SUATOINTALIO";

    /**
     * @param string $key
     * @param string $endpoint
     * @param int $keyTimeout
     * @return void
     */
    public function __construct($key, $endpoint, $keyTimeout = 900)
    {
        $this->_key = $key;
        $this->_endpoint = $endpoint;
        $this->_keyTimeout = $keyTimeout;
    }

    /**
     * @param string $token
     * @param int $attachmentId
     * @param int $timestamp
     * @return boolean
     */
    public function validateIncomingToken($token, $attachmentId, $timestamp)
    {
        return ($token == $this->getIncomingToken($attachmentId, $timestamp))
               && (abs(time()-$timestamp) < $this->_keyTimeout);
    }

    /**
     * @param int $attachmentId
     * @param int $timestamp
     * @return string
     */
    public function getIncomingToken($attachmentId, $timestamp)
    {
        return hash('sha256', $this->_key . $attachmentId . $timestamp . self::INCOMING_STRING);
    }

    /**
     * @param int $attachmentId
     * @param int $timestamp
     * @return string
     */
    private function getOutgoingToken($attachmentId, $timestamp)
    {
        return hash('sha256', $this->_key . $attachmentId . $timestamp . self::OUTGOING_STRING);
    }

    /**
     * @param int $attachmentId
     * @param string $fileType
     * @param string $fileService
     * @param int $fileId
     * @return void
     */
    public function sendUploadConfirmation($attachmentId, $fileType, $fileService, $fileId)
    {
        $timestamp = time();
        $token = $this->getOutgoingToken($attachmentId, $timestamp);
    }

    /**
     * @param int string
     * @param unknown_type $characters
     * @return string
     */
    public function getRandomString(
        $length = 8,
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'
    )
    {
        $string = "";
        for($i = 0; $i < $length; ++$i)
        $string .= $characters[rand(0,strlen($characters)-1)];
        return $string;
    }
}
