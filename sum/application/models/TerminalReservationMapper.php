<?php
class Default_Model_TerminalReservationMapper extends Default_Model_Mapper {
	
	protected $_dbtableType = 'Default_Model_DbTable_TerminalReservation';
	
    public function save(Default_Model_TerminalReservation $reservation)
    {
        $data = array(
            'userid'   => $reservation->getUserId(),
            'terminalid' => $reservation->getTerminalId(),
            'start' => $reservation->getStartDate()->toString('YYYY-MM-dd HH:mm:ss'),
        	'end' => $reservation->getEndDate()->toString('YYYY-MM-dd HH:mm:ss')
        );

        if (null === ($id = $reservation->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
            $reservation->setId($this->getDbTable()->getAdapter()->lastInsertId());
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
	function convertRowToEntry($row, Default_Model_TerminalReservation $entry) {
		$entry->setId($row->id)
		->setUserId($row->userid)
		->setTerminalId($row->terminalid)
		->setStartDate(new Zend_Date($row->start))
		->setEndDate(new Zend_Date($row->end))
		->setRow($row)
		->setMapper($this);
	}
}