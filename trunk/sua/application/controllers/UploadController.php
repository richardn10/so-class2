<?php

class UploadController extends Zend_Controller_Action
{
	private $_bootstrap;

	public function init() {
		$this->_bootstrap = $this->getInvokeArg('bootstrap');
		
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('submit', 'xml')
                      ->initContext();
	}
	
	public function processAction() {
		$pid = getmypid();
		
		$works = Work::findByPidAndFinished($pid, false);
		
		foreach($works as $work) {
			$work->current_pid = null;
			$work->save();
		}
		
		while(true) {
			Work::setWorksToPid($pid, 1);
			
			$works = Work::findByPidAndFinished($pid, false, true);
			
			if(count($works) == 0) break;
			
			$uploadProcessor = $this->_bootstrap->getResource('uploadProcessor');
			
			foreach($works as $work) {
				echo "Start processing work: ".$work->id."<br>\n";
				$uploadProcessor->process($work);
			}
		}
				
//		$youtubeContainer = $this->_bootstrap->getResource('youtube');
//		$ftp = $this->_bootstrap->getResource('ftp');
//		$intalio = $this->_bootstrap->getResource('intalio');
//		
//		foreach($works as $work) {
//			switch($work->getFiletype()) {
//				case 'image':
//					$ftp->upload(APPLICATION_PATH ."/../data/queue/", $work->getFilename());
//					$intalio->sendUploadConfirmation($work->getCorrelationId(), 'image', 'ftp', $work->getFilename());
//					$work->setFinishedNow();
//					$work->save();
//					rename(APPLICATION_PATH ."/../data/queue/". $work->getFilename(), APPLICATION_PATH ."/../data/backup/". $work->getFilename());
//					break;
//				case 'video':
//					$yt = $youtubeContainer->getYoutube();
//					
//					$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
//					$filesource = $yt->newMediaFileSource('file.mov');
//					$filesource->setContentType('video/quicktime');
//					// set slug header
//					$filesource->setSlug('file.mov');
//					
//
//					$intalio->sendUploadConfirmation($work->getCorrelationId(), 'video', 'youtube', $work->getFilename());
//					$work->setFinishedNow();
//					$work->save();
//					rename(APPLICATION_PATH ."/../data/queue/", $work->getFilename(), APPLICATION_PATH ."/../data/backup/", $work->getFilename());
//					break;
//				default: 
//					$work->setError(1);
//					$work->save();
//			}
//		}
	}
	
	public function cleanAction() {
		throw new Exception("Not in use yet");
	}
	
	public function indexAction() {

		if(!$this->_hasParam('file_id')
		    || !$this->_hasParam('form_pending_id')
		    || !$this->_hasParam('title')
		    || !$this->_hasParam('description')
			|| !$this->_hasParam('timestamp')
			|| !$this->_hasParam('token')
			|| !$this->_hasParam('return_url')
			|| !$this->_hasParam('return_element')
			|| !$this->_hasParam('filetype')
			) 
		{
			throw new Exception('Not all parameters are provided');
		}
		
		if(!$this->_bootstrap->getResource('intalio')->validateIncomingToken(
				$this->_getParam('token'),
				$this->_getParam('file_id'),
				$this->_getParam('timestamp')
			)
		) {
			throw new Exception('Token not valid');
		}
		
//		$form = new Form_Upload();
//		if($this->getRequest()->isPost()) {
//			
//			
//			if( $this->_getParam('filetype') == 'image') {
//				$form->file->addValidator('MimeType', true, array('image/jpeg', 'image/pjpeg','image/gif','image/png'));
//			} elseif( $this->_getParam('filetype') == 'video') {
//				throw new Exception('Video not supported yet');
//				$form->file->addValidator('MimeType', true, array('video/x-msvideo'));
//			} else {
//				throw new Exception('No valid filetype provided');
//			}
//			
//			if (!$form->isValid($this->getRequest()->getPost())) 
//			{
//			    throw new Exception('Bad data: '.print_r($form->getMessages(), true));
//			}
//			
//			try {
//				$form->file->receive();
//			} 
//			catch (Zend_File_Transfer_Exception $e) 
//			{
//				throw new Exception('Bad data: '.$e->getMessage());
//			}
//			
//			$fileinfo = $form->file->getFileInfo();
//			
////			if(is_array($form->file->getFilename())) {
////				foreach($form->file->getFilename() as $key => $filename) {
////					$newFilename = $this->_bootstrap->getResource('intalio')->getRandomString().'.'.$this->getExtension($fileinfo[$key]['type']);
////					$newFullFilename = APPLICATION_PATH ."/../data/queue/".$newFilename;
////					rename($filename, $newFullFilename);
////					$work = new Model_Work($this->_getParam('correlationid'), $newFilename, $this->_getParam('filetype'));
////					$work->save();
////				}
////			} else {
//				
//			$newFilename = $this->_bootstrap->getResource('intalio')->getRandomString().'.'.$this->getExtension($fileinfo['file']['type']);
//			$newFullFilename = APPLICATION_PATH ."/../data/queue/".$newFilename;
//			rename($form->file->getFilename(), $newFullFilename);
//			//$work = new Model_Work($this->_getParam('correlationid'), $newFilename, $this->_getParam('filetype'));
//			//$work->save();
//			
//			$work = new Work();
//			$work->attachment_id = $this->_getParam('attachmentid');
//			$work->file_name = $newFilename;
//			$work->file_type = $this->_getParam('filetype');
//			$work->file_mimetype = $fileinfo['file']['type'];
//			$work->current_pid = getmypid();
//			$work->save();
//			
//			$statusLine = new StatusLine();
//			$statusLine->process_id = getmypid();
//			$statusLine->action = "media_received";
//			$statusLine->event_start = $statusLine->event_end = date('Y-m-d H:i:s');
//			$statusLine->success = true;
//			$statusLine->finished = true;
//			$statusLine->link('Work', $work->id);
//			$statusLine->save();
//				
////			}
//			
//			$uploadProcessor = $this->_bootstrap->getResource('uploadProcessor');
//			$uploadProcessor->createThumbnail($work);
//			
//			$work->current_pid = null;
//			$work->save();
//			
//			$this->view->nosuccess = false;
//			$this->view->return_url = $this->_getParam('return_url');
//			$this->view->return_element = $this->_getParam('return_element');
//			$this->view->filename = $newFilename;
//			//return $this->_helper->redirector('success', 'upload','default',array('return_url' => urlencode($this->_getParam('return_url')), 'return_element' => $this->_getParam('return_element'), 'filename' => $newFilename) );
//		}
//    	else {
    		
    		$formActionParams = $this->getRequest()->getParams();
    		$formActionParams['action'] = 'submit';
    		$formActionParams['format'] = 'xml';
    		
    		$this->view->formActionParams = array_map('urlencode',$formActionParams);
    		$this->view->return_url = $formActionParams['return_url'];
    		$this->view->nosuccess = true;
		
        	$this->view->form = new Form_Upload();
//    	}
	}
	
	public function submitAction() {
		
		$this->view->success = true;
		$this->view->message = '';
		
		if(!$this->_hasParam('file_id')
		    || !$this->_hasParam('form_pending_id')
		    || !$this->_hasParam('title')
		    || !$this->_hasParam('description')
			|| !$this->_hasParam('timestamp')
			|| !$this->_hasParam('token')
			|| !$this->_hasParam('return_url')
			|| !$this->_hasParam('return_element')
			|| !$this->_hasParam('filetype')
			) 
		{
			$this->view->success = false;
			$this->view->message ="Not all parameters are provided";
			return;
		}
		
		if(!$this->_bootstrap->getResource('intalio')->validateIncomingToken(
				$this->_getParam('token'),
				$this->_getParam('file_id'),
				$this->_getParam('timestamp')
			)
		) {
			$this->view->success = false;
			$this->view->message ="Token not valid";
			return;
		}
		
		$form = new Form_Upload();
		if(!$this->getRequest()->isPost()) {
			$this->view->success = false;
			$this->view->message ="Wrong protocol";
			return;
		} 
			
			
		if( $this->_getParam('filetype') == 'image') {
			$form->file->addValidator('MimeType', true, array('image/jpeg', 'image/pjpeg','image/gif','image/png'));
		} elseif( $this->_getParam('filetype') == 'video') {
			throw new Exception('Video not supported yet');
			$form->file->addValidator('MimeType', true, array('video/x-msvideo'));
		} else {
			$this->view->success = false;
			$this->view->message = "Not a valid filetype (".$this->_getParam('filetype').")";
			return;
		}
			
		if (!$form->isValid($this->getRequest()->getPost())) 
		{
			$this->view->success = false;
			$messages = $form->getMessages();
			$messageStrings = array();
			foreach($messages as $messageArray) 
				$messageStrings[] = implode(', ',$messageArray);
			
			$this->view->message = implode(', ',$messageStrings);
//			$this->view->message = print_r($form->getMessages(),true);
			return;
		}
			
		try {
			$form->file->receive();
		} 
		catch (Zend_File_Transfer_Exception $e) 
		{
			$this->view->success = false;
			$this->view->message = $e->getMessage();
			return;
		}
		
		$fileinfo = $form->file->getFileInfo();
		
		$newFilename = $this->_bootstrap->getResource('intalio')->getRandomString().'.'.$this->getExtension($fileinfo['file']['type']);
		$newFullFilename = APPLICATION_PATH ."/../data/queue/".$newFilename;
		rename($form->file->getFilename(), $newFullFilename);

		$work = new Work();
		$work->file_id = $this->_getParam('file_id');
		$work->form_pending_id = $this->_getParam('form_pending_id');
		$work->title= $this->_getParam('title');
		$work->description = $this->_getParam('description');
		$work->file_name = $newFilename;
		$work->file_type = $this->_getParam('filetype');
		$work->file_mimetype = $fileinfo['file']['type'];
		$work->current_pid = getmypid();
		$work->save();
			
		$statusLine = new StatusLine();
		$statusLine->process_id = getmypid();
		$statusLine->action = "media_received";
		$statusLine->event_start = $statusLine->event_end = date('Y-m-d H:i:s');
		$statusLine->success = true;
		$statusLine->finished = true;
		$statusLine->link('Work', $work->id);
		$statusLine->save();
				
			
		$uploadProcessor = $this->_bootstrap->getResource('uploadProcessor');
		$uploadProcessor->createThumbnail($work);
		
		$work->current_pid = null;
		$work->save();
		
		$this->view->filename = $newFilename;
			
		$this->view->message = "Everything ok";
	}
	
//	public function successAction() {
//		if(!$this->_hasParam('filename')
//			|| !$this->_hasParam('return_url')
//			|| !$this->_hasParam('return_element')
//			) 
//		{
//			throw new Exception('Not all parameters are provided');
//		}
//		
//		$this->view->filename = $this->_getParam('filename');
//		$this->view->return_url = urldecode($this->_getParam('return_url'));
//		$this->view->return_element = $this->_getParam('return_element');
//	}
	
	public function statusAction() {
		$works = Work::findAll();
		$this->view->works = $works;
		$this->view->ftpurl = $this->_bootstrap->getResource('ftp')->getTargeturl();
	}
	
	
	public function testtokenAction() {
//		throw new Exception("Not in use yet");
		
		$this->view->timestamp = $timestamp = time();
		$this->view->attachmentId = $attachmentId = rand(10000000, 99999999);
		$this->view->token = $this->_bootstrap->getResource('intalio')->getIncomingToken($attachmentId, $timestamp);
		$this->view->filetype = 'image';
	}
	
	public function getExtension($mimeType) {
		switch($mimeType) {
			case 'image/jpeg':
			case 'image/pjpeg':
				return 'jpg';
				break;
			case 'image/png':
				return 'png';
				break;
			case 'image/gif':
				return 'gif';
				break;
			case 'video/x-msvideo':
				return 'avi';
				break;
			default:
				throw new Exception('Unknown MimeType: '.$mimeType);
		}
		
	}

}