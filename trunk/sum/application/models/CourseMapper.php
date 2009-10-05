<?php

class Default_Model_CourseMapper extends Default_Model_Mapper {

	protected $_dbtableType = 'Default_Model_DbTable_Course';
	    
    public function save(Default_Model_Course $course)
    {
        $data = array(
            'name'   => $course->getName(),
            'number_lessons' => $course->getNumberOfLessons(),
            'lesson_price' => $course->getLessonPrice()
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
    
    
    function convertRowToEntry($row, Default_Model_Course $entry) {
    	$entry->setId($row->id)
        	  ->setName($row->name)
              ->setNumberOfLessons($row->number_lessons)
              ->setLessonPrice($row->lesson_price)
              ->setMapper($this);
    }
	
    
}
