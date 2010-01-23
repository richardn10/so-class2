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

class So_Fileprocessor_Action_Ftp extends So_Fileprocessor_Action
{

    protected function _doAction($work)
    {

        if(false === $connection = ftp_connect($this->_options['host'], $this->_options['port']))
            throw new Exception("FTP couldn't connect");

        if(!ftp_login($connection, $this->_options['username'], $this->_options['password']))
            throw new Exception("FTP login details wrong") ;

        if(!ftp_chdir($connection, $this->_options['target_path']))
            throw new Exception("FTP target directory does not exist") ;

        if(!ftp_pasv($connection, true))
            throw new Exception("FTP Passive mode not supported");

        if(!ftp_put($connection, $work->file_name, $this->_options['source_path'].'/'.$work->file_name, FTP_BINARY))
            throw new Exception("FTP Upload failed");
        else $this->_success = true;

        $this->_resultUrl = $this->_options['result_url'].$work->file_name;
    }
}