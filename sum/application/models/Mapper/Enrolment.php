<?php

class Default_Model_Mapper_Enrolment extends Default_Model_Mapper {
	
	protected $_dbtableType = 'Default_Model_DbTable_Enrolment';
	
    public function save(Default_Model_Enrolment $enrolment)
    {
        $data = array(
            'userid'   => $enrolment->getUserId(),
            'courseid' => $enrolment->getCourseId(),
        	'enrolment_date' => $enrolment->getEnrolmentDate()->toString('YYYY-MM-dd HH:mm:ss')
        );
        
        if(null !== $enrolment->getFinishDate()) 
        	$data['finish_date'] = $enrolment->getFinishDate()->toString('YYYY-MM-dd HH:mm:ss');

        if (null === ($id = $enrolment->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('enrolmentid = ?' => $id));
			
        }
    }
    
    public function find($id, Default_Model_Enrolment $enrolment) {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $this->convertRowToEntry($row, $enrolment);
    	
    }
    
	function getUser(Default_Model_Enrolment $enrolment) {
		$row = $enrolment->getRow()->findParentRow('Default_Model_DbTable_User');
		
		$user = new Default_Model_User();
		$user->getMapper()->convertRowToEntry($row, $user);
		return $user;
	}
	
	function getCourse(Default_Model_Enrolment $enrolment) {
		$row = $enrolment->getRow()->findParentRow('Default_Model_DbTable_Course');

		$course = new Default_Model_Course();
		$course->getMapper()->convertRowToEntry($row, $course);
		return $course;
	}
	
	function getNumberLessons(Default_Model_Enrolment $enrolment) {
		$lessonMapper = new Default_Model_Mapper_Lesson();
		return $lessonMapper->getNumberLessons($enrolment->getId());
	}
	
    function convertRowToEntry($row, Default_Model_Enrolment $entry) {
    	
    	$entry->setId($row->enrolmentid)
        	  ->setUserid($row->userid)
              ->setCourseid($row->courseid)
              ->setEnrolmentDate(new Zend_Date($row->enrolment_date, Zend_Date::ISO_8601))
              ->setRow($row)
              ->setMapper($this);
        if(!is_null($row->finish_date)) 
        	$entry->setFinishDate(new Zend_Date($row->finish_date, Zend_Date::ISO_8601));
    }
}