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


class So_Fileprocessor_Action_YoutubeUpload extends So_Fileprocessor_Action {

    protected function _doAction($work)
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

        $yt = new Zend_Gdata_YouTube($httpClient, $this->_options['applicationId'], $this->_options['clientId'], $this->_options['developerKey']);
        $yt->setMajorProtocolVersion(2);


        $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

        // create a new Zend_Gdata_App_MediaFileSource object
        $filesource = $yt->newMediaFileSource($this->_options['source_path'].'/'.$work->file_name);
        $filesource->setContentType($work->file_mimetype);
        // set slug header
        $filesource->setSlug($work->file_name);

        // add the filesource to the video entry
        $myVideoEntry->setMediaSource($filesource);

        $myVideoEntry->setVideoTitle($work->title);
        $myVideoEntry->setVideoDescription($work->description);
        // The category must be a valid YouTube category!
        $myVideoEntry->setVideoCategory('Autos');

        // Set keywords. Please note that this must be a comma-separated string
        // and that individual keywords cannot contain whitespace
        $myVideoEntry->SetVideoTags('so, test');

        // set some developer tags -- this is optional
        // (see Searching by Developer Tags for more details)
        $myVideoEntry->setVideoDeveloperTags(array('testtag'));

        $myVideoEntry->setVideoPrivate();

        // upload URI for the currently authenticated user
        $uploadUrl = 'http://uploads.gdata.youtube.com/feeds/api/users/default/uploads';

        // try to upload the video, catching a Zend_Gdata_App_HttpException,
        // if available, or just a regular Zend_Gdata_App_Exception otherwise
        $newEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');

        $this->_success = true;
    }
}