<?php

/*
 * CREATE VIEW ActiveReservations as SELECT id as reservationid, terminalid, userid, start, end FROM TerminalReservation WHERE start < UTC_TIMESTAMP() AND end > UTC_TIMESTAMP()
 * 
 * CREATE VIEW TerminalStatus as SELECT terminalid, userid, start, end, id as reservationid, NULL as loginid FROM TerminalReservation WHERE start < UTC_TIMESTAMP() AND end > UTC_TIMESTAMP()
 * 
 * CREATE VIEW TerminalStatus as
SELECT t.id as terminalid, t.name, tr.reservationid, tr.userid, u.username, u.firstname, u.lastname, tr.start, tr.end
FROM Terminal as t
LEFT JOIN (	SELECT id as reservationid, terminalid, userid, start, end FROM TerminalReservation WHERE start < UTC_TIMESTAMP() AND end > UTC_TIMESTAMP() ) as tr 
    ON (t.id = tr.terminalid)
JOIN User as u ON (tr.userid = u.id)

 *
 *CREATE VIEW TerminalStatus as
SELECT t.id as terminalid, t.name, tr.reservationid, tr.userid, u.username, u.firstname, u.lastname, tr.start, tr.end
FROM Terminal as t
LEFT JOIN ActiveReservations as tr 
    ON (t.id = tr.terminalid)
JOIN User as u ON (tr.userid = u.id)

 */
class Default_Model_TerminalMapper extends Default_Model_Mapper {

	protected $_dbtableType = 'Default_Model_DbTable_Terminal';

    public function save(Default_Model_Terminal $terminal)
    {
        $data = array(
            'name'   => $terminal->getName()
        );

        if (null === ($id = $terminal->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
            $terminal->setId($this->getDbTable()->getAdapter()->lastInsertId());
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Default_Model_Terminal $terminal) {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->convertRowToEntry($row, $terminal);
    	
    }
    
	function getUnreservedTerminals($minMinutes) {
		$select = $this->getDbTable()->select();
		$select->where("id not in (
			SELECT terminalid 
			FROM TerminalStatus 
		)  ");

		$resultSet = $this->getDbTable()->fetchAll($select);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_Terminal();
			$this->convertRowToEntry($row, $entry);
			$entries[] = $entry;
		}
		return $entries;

	}
	
	function getTerminalStatusses() {
		$select = $this->getDbTable()->select();
		$select->setIntegrityCheck(false)
			->from('Terminal')
			->joinLeft('TerminalStatus', 'Terminal.id = TerminalStatus.terminalid');
			
		$resultSet = $this->getDbTable()->fetchAll($select);
		
		$entries   = array();
		foreach ($resultSet as $row) {
			$terminal = new Default_Model_Terminal();
			$this->convertRowToEntry($row, $terminal);			

			$entries[] = (object) array('terminal' => $terminal, 'status' => $row);
		}
		return $entries;
	}

	function convertRowToEntry($row, Default_Model_Terminal $entry) {
		$entry->setId($row->id)
		->setName($row->name)
		->setRow($row)
		->setMapper($this);
	}
}