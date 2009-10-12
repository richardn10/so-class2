<?php

class Default_Model_Mapper_Lesson extends Default_Model_Mapper {
	
	protected $_dbtableType = 'Default_Model_DbTable_Lesson';
	
    public function save(Default_Model_Lesson $lesson)
    {
        $data = array(
            'enrolmentid'   => $lesson->getEnrolmentId(),
            'cost' => $lesson->getCost(),
        	'duration' => $lesson->getDuration(),
        	'debit_transactionid' => $lesson->getDebitTransactionId(),
        	'credit_transactionid' => $lesson->getCreditTransactionId(),
        	'date' => $lesson->getDate()->toString('YYYY-MM-dd HH:mm:ss')
        );

        if (null === ($id = $lesson->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            //$this->getDbTable()->update($data, array('id = ?' => $id));
            throw new Zend_Exception("Lesson not updatable");
        }
    }
	
	function getNumberLessons($enrolmentId) {
		$select = $this->getDbTable()->select();
		$select->from($this->getDbTable(), array('COUNT(*) as lessoncount'))
			 	->where('enrolmentid = ?', $enrolmentId)
			 	->group('enrolmentid');

		$rowset = $this->getDbTable()->fetchAll($select);
		
		if(count($rowset) < 1) return 0;
		else return $rowset[0]["lessoncount"];
	}
}