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

class So_Fileprocessor_Action_Thumbnail extends So_Fileprocessor_Action
{

    protected function _doAction($work)
    {
        $mediaConverter = new So_MediaConverter($this->_options['width']);

        switch($work->file_type) {
            case "image":
                $mediaConverter->makeImageThumbnail(
                    $this->_options['source_path'].'/'.$work->file_name,
                    $this->_options['target_path'].'/'.$work->file_name,
                    $work->file_mimetype
                );

                $work->thumbnail_file_name = $work->file_name;
                $work->save();
                break;
            case "video":
                $thumnailFileName = $this->_getNewFilename($work->file_name, 'jpg');

                $mediaConverter->makeVideoThumbnail(
                    $this->_options['source_path'].'/'.$work->file_name,
                    $this->_options['target_path'].'/'.$thumnailFileName
                );

                $work->thumbnail_file_name = $thumnailFileName;
                $work->save();
                break;
        }
        $this->_success = true;
    }

    private function _getNewFilename($oldFilename, $newExtension)
    {
        $dotLocation = strripos($oldFilename, '.');
        if(!$dotLocation)
            return $oldFilename. '.' . $newExtension;
        else
            return substr($oldFilename, 0, $dotLocation). '.' . $newExtension;
    }
}