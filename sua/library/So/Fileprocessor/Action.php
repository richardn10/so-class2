<?php

abstract class So_Fileprocessor_Action {
	
	protected $_actionName;
	protected $_work;
	protected $_options;
	
	protected $_statusLine;
	protected $_success;
	protected $_message;
	protected $_resultUrl;
	
	
	public function setActionName($actionName) {
		$this->_actionName = $actionName;
	}
	
	public function setOptions($options) {
		$this->_options = $options;
	}
	
	protected function _preAction($work) {
		$this->_statusLine = new StatusLine();
		$this->_success = false;
		$this->_message = null;
		$this->_resultUrl = null;
		
		$this->_statusLine->process_id = getmypid();
		$this->_statusLine->action = $this->_actionName;
		$this->_statusLine->event_start = date('Y-m-d H:i:s');
		
		$this->_statusLine->link('Work', $work->id);
		$this->_statusLine->save();
	}
	
	public function Act($work) {
		$this->_preAction($work);
		try {
			$this->_doAction($work);
		} catch(Exception $e) {
			$this->_success = false;
			$this->_message = $e->getMessage();
		}
		$this->_postAction();
	}
	
	protected abstract function _doAction($work);
	
	protected function _postAction() {
		$this->_statusLine->event_end = date('Y-m-d H:i:s');
		$this->_statusLine->finished = true;
		$this->_statusLine->success = $this->_success;
		$this->_statusLine->message = $this->_message;
		$this->_statusLine->result_url = $this->_resultUrl;
		$this->_statusLine->save();
	}
	
}