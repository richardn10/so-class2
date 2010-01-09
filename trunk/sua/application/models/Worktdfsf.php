<?php

class Model_Work {
	protected $_id;
	protected $_correlationId;
	protected $_filename;
	
	protected $_filetype;
	
	protected $_uploadPid;
	protected $_uploadStart = null;
	protected $_uploadEnd = null;
	protected $_errorflag;
	
	private $_row;
	
	public function __construct($correlationId = 0, $filename = null, $filetype = null, $id = null, $uploadPid = null, $uploadStart = null, $uploadEnd = null, $errorflag = 0) {
		$this->_correlationId = $correlationId;
		$this->_filename = $filename;
		$this->_filetype = $filetype;
		$this->_id = $id;
		$this->_uploadPid = $uploadPid;
		
		if(null !== $uploadStart) $this->_uploadStart = new Zend_Date($uploadStart, Zend_Date::ISO_8601);
		if(null !== $uploadEnd) $this->_uploadEnd = new Zend_Date($uploadEnd, Zend_Date::ISO_8601);

		$this->_errorflag = $errorflag;
	}
	
	public function save() {
		$data = array(
            'correlation_id' => $this->_correlationId,
            'filename' 		=> $this->_filename,
			'filetype'		=> $this->_filetype,
			'upload_pid'	=> $this->_uploadPid,
			'errorflag'		=> $this->_errorflag,
        );

        if(null !== $this->_uploadStart) 
        	$data['upload_start'] = $this->_uploadStart->toString('YYYY-MM-dd HH:mm:ss');
        if(null !== $this->_uploadEnd) 
            $data['upload_end'] = $this->_uploadEnd->toString('YYYY-MM-dd HH:mm:ss');
        
                
        if (null === ($id = $this->_id)) {
            $this->_getDbTable()->insert($data);
            $this->_id = $this->_getDbTable()->getAdapter()->lastInsertId();
        } else {
            $this->_getDbTable()->update($data, array('id = ?' => $this->_id));
        }
	}
	
	public function getCorrelationId() {
		return $this->_correlationId;	
	}
	
	public function getFiletype() {
		return $this->_filetype;
	}
	
	public function getFilename() {
		return $this->_filename;
	}
	
	public function setError($flag) {
		$this->_errorflag = $flag;
	}
	
	public function setFinishedNow() {
		$this->_uploadEnd = new Zend_Date();
	}
	
	public static function getByPid($pid, $includeErrors = false, $includeFinished = false) {
		$workModel = new Model_Work();

		$select = $workModel->_getDbTable()->select();
		$select->where('upload_pid = ?', $pid);
		
		if(!$includeErrors) $select->where('errorflag =0');
		if(!$includeFinished) $select->where('upload_end IS NULL');
			
		$rows = $workModel->_getDbTable()->fetchAll($select);
		
		$works = array();
		foreach($rows as $row) {
			$work = new Model_Work($row->correlation_id, $row->filename, $row->filetype, $row->id, $row->upload_pid, $row->upload_start, $row->upload_end, $row->errorflag);
			$work->_row = $row;
			$works[] = $work;
		}
		
		return $works;
	}
	
	public static function claimWorks($pid) {
		$workModel = new Model_Work();
		$time = new Zend_Date();
		$data = array(
			'upload_pid'	=> $pid,
			'upload_start'	=> $time->toString('YYYY-MM-dd HH:mm:ss'),
        );
		
		$workModel->_getDbTable()->update($data, array(
			'upload_pid IS NULL',
			'upload_start IS NULL',
			)
		);
		 
		return self::getByPid($pid);
	}
	
	protected $_dbtableType = 'Model_DbTable_Work';
    protected $_dbTable = null;
        
    private function _setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    private function _getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_setDbTable($this->_dbtableType);
        }
        return $this->_dbTable;
    }
	
} 