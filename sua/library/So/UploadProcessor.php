<?php

class So_UploadProcessor {
	
	private $_bootstrap;
	private $_mediaOptions;
	
	private $_currentRetry;
	
	public function __construct($bootstrap) {
		$this->_bootstrap = $bootstrap;
		$this->_mediaOptions = $this->_bootstrap->getOption('media');
	}
	
	private function sleepForError() {
		++$this->_currentRetry;
		sleep(pow(2, $this->_currentRetry));
	}
	
	public function process($work) {
		$this->_currentRetry == 0;
		try {
			while(true) {
				echo "Processing ".$work->id."<br>\n";
				if($this->_currentRetry > 10) throw new Exception("To much errors");
				
				$lastStatus = $work->getLastStatusLine();
				
				echo "&nbsp;&nbsp;\tStatusLine id ".$lastStatus->id." Action:".$lastStatus->action."<br>\n";
				switch($lastStatus->action) {
					case "media_received":
						if($lastStatus->success) $this->createThumbnail($work);
						else throw new Exception("Strange error");					
						break;
					case "create_thumbnail":
						if(!$lastStatus->success) $this->createThumbnail($work);
						else $this->convert($work);
						break;
					case "convert":
						if(!$lastStatus->success) $this->convert($work);
						else $this->upload($work);
						break;
					case "upload":
						if(!$lastStatus->success) $this->upload($work);
						else $this->report($work);
						break;
					case "report":
						if(!$lastStatus->success) $this->report($work);
						else {
							$work->finished = true;
							$work->save();
							return;
						}
					break;
				}
			}
		} catch(Exception $e) {
			$work->current_pid = null;
			$work->finished = false;
		}
		
	}
	
//	public function receive($work) {
//		$statusLine = new StatusLine();
//		
//		$statusLine->process_id = getmypid();
//		$statusLine->action = "media_received";
//		$statusLine->event_start = time();
//		
//		$statusLine->link('Work', $work->id);
//		$statusLine->save();
//		$statusLine->success = true;
//		
//		$statusLine->event_end = time();
//		$statusLine->finished = true;
//		$statusLine->save();
//		return $statusLine->success;
//	}
	
	public function createThumbnail($work) {
		$mediaConverter = new So_MediaConverter();
		
		$statusLine = new StatusLine();
		
		$statusLine->process_id = getmypid();
		$statusLine->action = "create_thumbnail";
		$statusLine->event_start = date('Y-m-d H:i:s');
		
		$statusLine->link('Work', $work->id);
		$statusLine->save();
		
		
		try {
			switch($work->file_type) {
				case "image":
					$mediaConverter->makeImageThumbnail(
						$this->_mediaOptions['queue_path'].'/'.$work->file_name, 
						$this->_mediaOptions['thumbnail_path'].'/'.$work->file_name, 
						$work->file_mimetype
					);
					$statusLine->success = true;
					break;
				case "video":
					$statusLine->success = true;
					$statusLine->message = "Video Thumbnailing not Implemented yet";
//					$mediaConverter->makeVideoThumbnail();
					break;
			}
		} catch(Exception $e) {
			$statusLine->message = $e->getMessage();
		}

		$statusLine->event_end = date('Y-m-d H:i:s');
		$statusLine->finished = true;
		$statusLine->save();
		return $statusLine->success;
	}
	
	public function convert($work) {
		$statusLine = new StatusLine();
		
		$statusLine->process_id = getmypid();
		$statusLine->action = "convert";
		$statusLine->event_start = date('Y-m-d H:i:s');
		
		$statusLine->link('Work', $work->id);
		$statusLine->save();
		
		try {
			switch($work->file_type) {
				case "image":
					$statusLine->success = true;
					$statusLine->message = "Images don't need to be converted";
					break;
				case "video":
					$statusLine->success = true;
					$statusLine->message = "Video conversion not Implemented yet";
					break;
			}
		} catch(Exception $e) {
			$statusLine->message = $e->getMessage();
		}

		$statusLine->event_end = date('Y-m-d H:i:s');
		$statusLine->finished = true;
		$statusLine->save();

		return $statusLine->success;
	}
	
	public function upload($work) {
		$statusLine = new StatusLine();
		
		$statusLine->process_id = getmypid();
		$statusLine->action = "upload";
		$statusLine->event_start = date('Y-m-d H:i:s');
		
		$statusLine->link('Work', $work->id);
		$statusLine->save();
		
		try {
			switch($work->file_type) {
				case "image":
					$ftp = $this->_bootstrap->getResource('ftp');
					$ftp->upload($this->_mediaOptions['queue_path'], $work->file_name);
					$statusLine->success = true;
					break;
				case "video":
					$statusLine->success = true;
					$statusLine->message = "Video upload not implemented yet";
					break;
			}
		} catch(Exception $e) {
			echo "exception<br>";
			echo $e->getTraceAsString();
			echo $e->getMessage();
			$statusLine->message = $e->getMessage();
		}
		
		
//		if($statusLine->success) {
//			rename($this->_mediaOptions['queue_path'].'/'. $work->getFilename(), $this->_mediaOptions['backup_path'].'/'. $work->getFilename());
//		}

		$statusLine->event_end = date('Y-m-d H:i:s');
		$statusLine->finished = true;
		$statusLine->save();
		return $statusLine->success;
	}
	
	public function report($work) {
		$statusLine = new StatusLine();
		
		$statusLine->process_id = getmypid();
		$statusLine->action = "report";
		$statusLine->event_start = date('Y-m-d H:i:s');
		
		$statusLine->link('Work', $work->id);
		$statusLine->save();
		
		try {

			$intalio = $this->_bootstrap->getResource('intalio');
			$intalio->sendUploadConfirmation(
				$work->attachment_id, 
				$work->file_type, 
				$work->file_type == 'image' ? 'ftp' : 'youtube', 
				$work->file_name 
			);
			$statusLine->success = true;

		} catch(Exception $e) {
			$statusLine->message = $e->getMessage();
		}

		$statusLine->event_end = date('Y-m-d H:i:s');
		$statusLine->finished = true;
		$statusLine->save();
		return $statusLine->success;
	}
}