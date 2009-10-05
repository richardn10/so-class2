<?php

class Default_Model_UserMapper extends Default_Model_Mapper {

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
    
    public function fetchEnrolmentCourses(Default_Model_User $user) {
    	$userRow = $user->getRow();
		if(null === $userRow) {
			throw new Zend_Exception("No user db row present");
		}
    	
    	$resultSet = $userRow->findManyToManyRowset('Default_Model_DbTable_Course', 'Default_Model_DbTable_Enrolment');
    	
    	$entries = array();
    	$enrolmentMapper = new Default_Model_EnrolmentMapper();
    	$courseMapper = new Default_Model_CourseMapper();
    	
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
		$courseMapper = new Default_Model_CourseMapper();
		return $courseMapper->fetchCoursesWithEnrolmentByUser($user->getId());
    }
    
    public function fetchEnrolments(Default_Model_User $user, $courseid) {
    	$select = $this->getDbTable()->select();
    	$select->where("Enrolment.courseid = ?", $courseid);
    	$resultSet = $this->getDbTable()->findDependentRowset('Default_Model_DbTable_Enrolment', 'User', $select);
    	
    	$entries = array();
    	foreach ($resultSet as $row) {
            $enrolment = new Default_Model_Enrolment();
            
            $enrolmentMapper->convertRowToEntry($row, $enrolment);
            $entries[] = $enrolment;
        }
        return $entries;
    	
    }
    
    protected function convertRowToEntry($row, Default_Model_User $entry) {
    	$entry->setId($row->id)
        	  ->setUsername($row->username)
              ->setFirstname($row->firstname)
              ->setLastname($row->lastname)
              ->setRow($row)
              ->setMapper($this);
    }
	
    
}