<?php

class Default_Model_Mapper_Course extends Default_Model_Mapper {

	protected $_dbtableType = 'Default_Model_DbTable_Course';
	    
    public function save(Default_Model_Course $course)
    {
        $data = array(
            'name'   => $course->getName(),
            'number_lessons' => $course->getNumberOfLessons(),
            'lesson_price' => $course->getLessonPrice(),
        	'lesson_length' => $course->getLessonLength()
        );

        if (null === ($id = $user->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Default_Model_Course $course) {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->convertRowToEntry($row, $course);
    	
    }
    
    public function fetchAll() {
    	$resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Course();
			$this->convertRowToEntry($row, $entry);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchCoursesWithEnrolmentByUser($userid) {
    	$select = $this->getDbTable()->select();
//    	$select->setIntegrityCheck(false)
//    	       ->from('Course')
//    	       ->joinLeft('Enrolment', 'Enrolment.courseid = Course.id')
//    	       ->where("Enrolment.enrolmentid IS NULL")
//    	       ->where("Enrolment.userid = ?", $userid);
    	
    	$select->where("id NOT IN (SELECT courseid FROM Enrolment WHERE userid = ?)", $userid);
    	
    	$resultSet = $this->getDbTable()->fetchAll($select);
    	$entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Course();
			$this->convertRowToEntry($row, $entry);
            $entries[] = $entry;
        }
        return $entries;
    	       
    }
    
    function getEnrolments(Default_Model_Course $course, $active = null) {
    	$select = $this->getDbTable()->select();
    	if(false === $active) 
    		$select->where('finish_date IS NOT NULL');
    	if(true === $active)
    		$select->where('finish_date IS NULL');
    	
    	$resultSet = $course->getRow()->findDependentRowset('Default_Model_DbTable_Enrolment', 'Course', $select);
    	
    	$entries   = array();
    	$enrolmentMapper = new Default_Model_Mapper_Enrolment();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Enrolment();
			$enrolmentMapper->convertRowToEntry($row, $entry);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    function convertRowToEntry($row, Default_Model_Course $entry) {
    	$entry->setId($row->id)
        	  ->setName($row->name)
              ->setNumberOfLessons($row->number_lessons)
              ->setLessonPrice($row->lesson_price)
              ->setLessonLength($row->lesson_length)
              ->setRow($row)
              ->setMapper($this);
    }
	
    
}
