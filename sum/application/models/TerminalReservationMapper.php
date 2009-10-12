<?php
class Default_Model_TerminalReservationMapper extends Default_Model_Mapper {
	
	protected $_dbtableType = 'Default_Model_DbTable_TerminalReservation';
	
    public function save(Default_Model_TerminalReservation $reservation)
    {
        $data = array(
            'userid'   => $reservation->getUserId(),
            'terminalid' => $reservation->getTerminalId(),
            'start' => $reservation->getStartDate()->toString('YYYY-MM-dd HH:mm:ss'),
        	'end' => $reservation->getEndDate()->toString('YYYY-MM-dd HH:mm:ss'),
        	'cancelled' => ($reservation->getCancelled() ? 1 : 0)
        );

        if (null === ($id = $reservation->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
            $reservation->setId($this->getDbTable()->getAdapter()->lastInsertId());
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Default_Model_TerminalReservation $terminalReservation) {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->convertRowToEntry($row, $terminalReservation);
    	
    }
    
    function getTerminal(Default_Model_TerminalReservation $reservation) {
    	$row = $reservation->getRow()->findParentRow('Default_Model_DbTable_Terminal');
		
		$terminal = new Default_Model_Terminal();
		$terminal->getMapper()->convertRowToEntry($row, $terminal);
		return $terminal;
    }
    
	function getUser(Default_Model_TerminalReservation $reservation) {
		$row = $reservation->getRow()->findParentRow('Default_Model_DbTable_User');
		
		$user = new Default_Model_User();
		$user->getMapper()->convertRowToEntry($row, $user);
		return $user;
	}
	
	function convertRowToEntry($row, Default_Model_TerminalReservation $entry) {
		$entry->setId($row->id)
		->setUserId($row->userid)
		->setTerminalId($row->terminalid)
		->setStartDate(new Zend_Date($row->start, Zend_Date::ISO_8601))
		->setEndDate(new Zend_Date($row->end, Zend_Date::ISO_8601))
		->setCancelled($row->cancelled == 1)
		->setRow($row)
		->setMapper($this);
	}
}