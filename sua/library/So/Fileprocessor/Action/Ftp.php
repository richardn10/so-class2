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

    /**
     * @param Work $work
     * @return void
     * @see library/So/Fileprocessor/So_Fileprocessor_Action#_doAction($work)
     */
    protected function _doAction($work)
    {
        /**
         * @var So_Ftp
         */
        $ftp = Zend_Controller_Front::getInstance()
                            ->getParam('bootstrap')
                            ->getResource('multiftp')
                            ->getFtp($this->_options['ftpresource']);

        $ftp->upload($this->_options['source_path'], $work->file_name);
        $this->_success = true;
        $this->_resultUrl = $ftp->getTargeturl().$work->file_name;
    }
}