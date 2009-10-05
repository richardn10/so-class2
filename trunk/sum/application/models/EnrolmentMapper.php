<?php

class Default_Model_EnrolmentMapper extends Default_Model_Mapper {
	
	
    function convertRowToEntry($row, Default_Model_Enrolment $entry) {
    	$entry->setId($row->id)
        	  ->setUserid($row->userid)
              ->setCourseid($row->courseid)
              ->setEnrolmentDate($row->enrolment_date)
              ->setFinishDate($row->finish_date)
              ->setMapper($this);
    }
}