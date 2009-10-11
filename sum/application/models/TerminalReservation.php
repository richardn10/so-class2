<?php
class Default_Model_TerminalReservation extends Default_Model_Abstract {
	protected $_id;
	protected $_terminalId;
	protected $_userId;
	protected $_startDate;
	protected $_endDate;
	
	
	protected $_mapperClass = 'Default_Model_TerminalReservationMapper';
	
	
	public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
	
	public function setTerminalId($id) {
        $this->_terminalId = (int) $id;
        return $this;
    }
    
    public function getTerminalId() {
    	return $this->_terminalId;
    }

	public function setUserId($id) {
        $this->_userId = (int) $id;
        return $this;
    }
    
    public function getUserId() {
    	return $this->_userId;
    }
    
    public function setStartDate(Zend_Date $date)
    {
        $this->_startDate = $date;
        return $this;
    }

    public function getStartDate()
    {
        return $this->_startDate;
    }
    
    public function setEndDate(Zend_Date $date)
    {
        $this->_endDate = $date;
        return $this;
    }

    public function getEndDate()
    {
        return $this->_endDate;
    }
}