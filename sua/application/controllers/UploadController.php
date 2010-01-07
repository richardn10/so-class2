<?php

class UploadController extends Zend_Controller_Action
{
	private $_bootstrap;

	public function init() {
		$this->_bootstrap = $this->getInvokeArg('bootstrap');
	}
	
	public function processAction() {
		$pid = getmypid();
		
		if(count($works = Model_Work::getByPid($pid)) > 0) {
			foreach($works as $work) {
				$work->setError(1);
				$work->save();
			}
		}
		
		$works = Model_Work::claimWorks($pid);
		
		$youtubeContainer = $this->_bootstrap->getResource('youtube');
		$ftp = $this->_bootstrap->getResource('ftp');
		$intalio = $this->_bootstrap->getResource('intalio');
		
		foreach($works as $work) {
			switch($work->getFiletype()) {
				case 'image':
					$ftp->upload(APPLICATION_PATH ."/../data/queue/", $work->getFilename());
					$intalio->sendUploadConfirmation($work->getCorrelationId(), 'image', 'ftp', $work->getFilename());
					$work->setFinishedNow();
					$work->save();
					rename(APPLICATION_PATH ."/../data/queue/". $work->getFilename(), APPLICATION_PATH ."/../data/backup/". $work->getFilename());
					break;
				case 'video':
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
					break;
				default: 
					$work->setError(1);
					$work->save();
			}
		}
	}
	
	public function cleanAction() {
		
	}
	
	public function indexAction() {
		if(!$this->_hasParam('correlationid')
			|| !$this->_hasParam('timestamp')
			|| !$this->_hasParam('token')
			) 
		{
			throw new Exception('Not all parameters are provided');
		}
		
		if(!$this->_bootstrap->getResource('intalio')->validateIncomingToken(
				$this->_getParam('token'),
				$this->_getParam('correlationid'),
				$this->_getParam('timestamp')
			)
		) {
			throw new Exception('Token not valid');
		}
		
		$form = new Form_Upload();
		if($this->getRequest()->isPost()) {
			
			
			if($this->_hasParam('filetype') && $this->_getParam('filetype') == 'image') {
				$form->file->addValidator('MimeType', true, array('image/jpeg','image/gif','image/png'));
			} else {
				$form->file->addValidator('MimeType', true, array('video/x-msvideo'));
			}
			
			if (!$form->isValid($this->getRequest()->getPost())) 
			{
			    throw new Exception('Bad data: '.print_r($form->getMessages(), true));
			}
			
			try {
				$form->file->receive();
			} 
			catch (Zend_File_Transfer_Exception $e) 
			{
				throw new Exception('Bad data: '.$e->getMessage());
			}
			
			$fileinfo = $form->file->getFileInfo();
			
			if(is_array($form->file->getFilename())) {
				foreach($form->file->getFilename() as $key => $filename) {
					$newFilename = $this->_bootstrap->getResource('intalio')->getRandomString().'.'.$this->getExtension($fileinfo[$key]['type']);
					$newFullFilename = APPLICATION_PATH ."/../data/queue/".$newFilename;
					rename($filename, $newFullFilename);
					$work = new Model_Work($this->_getParam('correlationid'), $newFilename, $this->_getParam('filetype'));
					$work->save();
				}
			} else {
				$newFilename = $this->_bootstrap->getResource('intalio')->getRandomString().'.'.$this->getExtension($fileinfo['file']['type']);
				$newFullFilename = APPLICATION_PATH ."/../data/queue/".$newFilename;
				rename($form->file->getFilename(), $newFullFilename);
				$work = new Model_Work($this->_getParam('correlationid'), $newFilename, $this->_getParam('filetype'));
				$work->save();
			}
			
			$this->view->successUpload = true;
			$this->view->correlationId = $this->_getParam('correlationid');
		}
    	else {
    		$this->view->successUpload = false;
        	$this->view->form = new Form_Upload();
    	}
	}
	
	public function statusAction() {
		
	}
	
	
	public function testtokenAction() {
		$this->view->timestamp = $timestamp = time();
		$this->view->correlationId = $correlationId = rand(10000000, 99999999);
		$this->view->token = $this->_bootstrap->getResource('intalio')->getIncomingToken($correlationId, $timestamp);
		$this->view->filetype = 'image';
	}
	
	public function getExtension($mimeType) {
		switch($mimeType) {
			case 'image/jpeg':
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