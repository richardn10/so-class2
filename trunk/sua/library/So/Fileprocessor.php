<?php

class So_Fileprocessor {
	
	private $_config;
	private $_filetypes;
	private $_actions;
	private $_actionClass;
	private $_actionOptions;
	private $_nextAction;
	
	const MAX_FAILS = 2;

	public function __construct($config) {
		$this->_config = $config;
		$this->_filetypes = array_keys($config);
		$this->_actions = array();
		$this->_nextAction = array();
		$this->_actionOptions = array();
		$this->_actionClass  = array();
		foreach($this->_filetypes as $filetype) {
			$this->_actions[$filetype] = array();
			$this->_nextAction[$filetype] = array();
			$this->_actionOptions[$filetype] = array();
			$this->_actionClass[$filetype] = array();
			foreach($config[$filetype] as $actionName => $actionConfig) {
				$this->_actionClass[$filetype][$actionName] = $actionConfig['actionClass'];
				$this->_nextAction[$filetype][$actionName] = strlen(trim($actionConfig['nextAction'])) > 0 ? $actionConfig['nextAction'] : null;
				$this->_actionOptions[$filetype][$actionName] = $actionConfig['options'];
			} 
				
		}
	}
	
	public function processOneAction($work, $actionName) {
		if($work->current_pid != getmypid()) 
			throw new Exception("Work is not claimed!");
			
		if(!isset($this->_actions[$work->file_type][$actionName])) {
			$this->_loadAction($work->file_type, $actionName);
		}
		
		$this->_actions[$work->file_type][$actionName]->Act($work);
	}
	
	public function claimWork($work = null) {
		$work->current_pid = getmypid();
		$work->save();
	}
	
	public function claimWorks($numberOfWorks = 1) {
		Work::setWorksToPid(getmypid(), $numberOfWorks);
	}
	
	public function releaseWork($work) {
		$work->current_pid = null;
		$work->save();
	}
	
	public function process($work) {
		$numFails = 0;
		
		$lastAction = $work->getLastStatusLine();
		
		while(!$work->finished && $numFails < self::MAX_FAILS ) {
			if($lastAction->success) {
				if(!is_null($this->_nextAction[$work->file_type][$lastAction->action])) {
					$this->processOneAction($work,$this->_nextAction[$work->file_type][$lastAction->action]);
				}
				else {
					$work->finished = true;
					$work->save();
				}
			} else {
				$this->processOneAction($work,$lastAction->action);
			}
			
			$lastAction = $work->getLastStatusLine();
			if(!$lastAction->success) ++$numFails;
		}
		
		$this->releaseWork($work);
	}
	
	private function _loadAction($filetype, $actionName) {
		$actionClass = $this->_actionClass[$filetype][$actionName];
		$classname = 'So_Fileprocessor_Action_'.$actionClass;
		if(isset($this->_actions[$filetype][$actionName]) && $this->_actions[$filetype][$actionName] instanceof $classname) 
			throw new Exception($classname +' already loaded');
		require_once 'So/Fileprocessor/Action/'.$actionClass.'.php';
		$r = new ReflectionClass($classname);
		$this->_actions[$filetype][$actionName] = $r->newInstance();
		$this->_actions[$filetype][$actionName]->setActionName($actionName);
		$this->_actions[$filetype][$actionName]->setOptions($this->_actionOptions[$filetype][$actionName]);
	}
	
}