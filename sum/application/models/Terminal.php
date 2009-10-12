<?php
class Default_Model_Terminal extends Default_Model_Abstract {
	protected $_id;
	protected $_name;
	
	protected $_currentReservation = null;
	
	protected $_mapperClass = 'Default_Model_Mapper_Terminal';
	
    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
	
	public function setName($text)
    {
        $this->_name = (string) $text;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
    
	public function setCurrentReservation(Default_Model_TerminalReservation $reservation)
    {
        $this->_currentReservation = $reservation;
        return $this;
    }
    
    public function getCurrentReservation() {
    	return $this->_currentReservation;
    }
	
	function getUnreservedTerminals($minMinutes) {
		return $this->getMapper()->getUnreservedTerminals($minMinutes);
	}
	
	function getTerminalStatusses() {
		return $this->getMapper()->getTerminalStatusses();
	}
}