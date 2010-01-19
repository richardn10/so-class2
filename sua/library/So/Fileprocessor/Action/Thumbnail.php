<?php

class So_Fileprocessor_Action_Thumbnail extends So_Fileprocessor_Action {
	
	protected function _doAction($work) {
		$mediaConverter = new So_MediaConverter($this->_options['width']);
		
		switch($work->file_type) {
			case "image":
				$mediaConverter->makeImageThumbnail(
					$this->_options['source_path'].'/'.$work->file_name, 
					$this->_options['target_path'].'/'.$work->file_name, 
					$work->file_mimetype
				);
				break;
			case "video":
				throw new Exception("Video Thumbnailing not Implemented yet");
//				$mediaConverter->makeVideoThumbnail();
				break;
		}
		$this->_success = true;
	}
}