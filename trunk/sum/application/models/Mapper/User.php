<?php

class Default_Model_Mapper_User extends Default_Model_Mapper {

	protected $_dbtableType = 'Default_Model_DbTable_User';
	    
    public function save(Default_Model_User $user)
    {
        $data = array(
            'username'   => $user->getUsername(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
        	'type' => 'customer'
        );

        if (null === ($id = $user->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
            $user->setId($this->getDbTable()->getAdapter()->lastInsertId());
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Default_Model_User $user) {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->convertRowToEntry($row, $user);
    	
    }
    
    public function findByAnyField($needle) {
    	$select = $this->getDbTable()->select();
    	$select->where('username LIKE ?', '%'.$needle.'%')
    			->orWhere('firstname LIKE ?', '%'.$needle.'%')
    			->orWhere('lastname LIKE ?', '%'.$needle.'%');
    	
    	$resultSet = $this->getDbTable()->fetchAll($select);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_User();
            $this->convertRowToEntry($row, $entry);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    public function fetchAll() {
    	$resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_User();
			$this->convertRowToEntry($row, $entry);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchEnrolmentCourses(Default_Model_User $user, $finished = null) {
    	$userRow = $user->getRow();
		if(null === $userRow) {
			throw new Zend_Exception("No user db row present");
		}
    	$select = $this->getDbTable()->select();
    	if(false === $finished)
    		$select->where('finish_date IS NULL');
    	if(true === $finished)
    		$select->where('finish_date IS NOT NULL');
    	$resultSet = $userRow->findManyToManyRowset('Default_Model_DbTable_Course', 'Default_Model_DbTable_Enrolment', null, null,$select);
    	
    	$entries = array();
    	$enrolmentMapper = new Default_Model_Mapper_Enrolment();
    	$courseMapper = new Default_Model_Mapper_Course();
    	
        foreach ($resultSet as $row) {
            $enrolment = new Default_Model_Enrolment();
            $course = new Default_Model_Course();
            
            $enrolmentMapper->convertRowToEntry($row, $enrolment);
            $courseMapper->convertRowToEntry($row, $course);
            
            $enrolment->setCourse($course);
            
            $entries[] = $enrolment;
        }
        return $entries;
    }
    
    public function fetchUnEnrolledCourses(Default_Model_User $user) {
		$courseMapper = new Default_Model_Mapper_Course();
		return $courseMapper->fetchCoursesWithEnrolmentByUser($user->getId());
    }
    
    public function fetchEnrolments(Default_Model_User $user, $courseid) {
    	$select = $this->getDbTable()->select();
    	$select->where("Enrolment.courseid = ?", $courseid);
    	$resultSet = $user->getRow()->findDependentRowset('Default_Model_DbTable_Enrolment', 'User', $select);
    	
    	$enrolmentMapper = new Default_Model_EnrolmentMapper();
    	
    	$entries = array();
    	foreach ($resultSet as $row) {
            $enrolment = new Default_Model_Enrolment();
            
            $enrolmentMapper->convertRowToEntry($row, $enrolment);
            $entries[] = $enrolment;
        }
        return $entries;
    	
    }
    
    public function getTransactionBalance(Default_Model_User $user) {
    	$transMapper = new Default_Model_Mapper_Transaction();
    	return $transMapper->getBalance($user->getId());
    }
    
    public function getActiveReservations(Default_Model_User $user) {
    	$select = $this->getDbTable()->select();
    	$select->setIntegrityCheck(false)
    		->from('TerminalStatus as ts', array('t.name as terminalname', 'ts.start', 'ts.end'))
    		->join('Terminal as t', 'ts.terminalid = t.id')
    		->where('userid = ?', $user->getId());
    		
    	$rowSet = $this->getDbTable()->fetchAll($select);
    	
    	$entries = array();
    	foreach($rowSet as $row) {
    		$entry = array(
    			'terminalName' => $row->terminalname,
    			'startDate' => new Zend_Date($row->start, Zend_Date::ISO_8601),
    			'endDate' => new Zend_Date($row->end, Zend_Date::ISO_8601)
    		);
    		$entries[] = (object) $entry;
    	}
    	
    	return $entries;
    	    	
    }
    
    public function getTransactionHistory(Default_Model_User $user) {
    	$transactionMapper = new Default_Model_Mapper_Transaction();
    	return $transactionMapper->getCompleteHistory($user->getId());
    }
    
    function convertRowToEntry($row, Default_Model_User $entry) {
    	$entry->setId($row->id)
        	  ->setUsername($row->username)
              ->setFirstname($row->firstname)
              ->setLastname($row->lastname)
              ->setRow($row)
              ->setMapper($this);
    }
	
    
}