<?php

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