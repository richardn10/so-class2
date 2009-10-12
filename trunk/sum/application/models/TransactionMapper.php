<?php

class Default_Model_TransactionMapper extends Default_Model_Mapper {
	
	protected $_dbtableType = 'Default_Model_DbTable_Transaction';
	
    public function save(Default_Model_Transaction $transaction)
    {
        $data = array(
            'userid'   => $transaction->getUserId(),
            'amount' => $transaction->getAmount(),
        	'type' => $transaction->getType(),
        	'date' => $transaction->getDate()->toString('YYYY-MM-dd HH:mm:ss')
        );

        if (null === ($id = $transaction->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
            $d = new Default_Model_DbTable_Transaction();
            $transaction->setId($this->getDbTable()->getAdapter()->lastInsertId());
        } else {
            //$this->getDbTable()->update($data, array('id = ?' => $id));
            throw new Zend_Exception("Transaction not updatable");
        }
    }
    
	function getBalance($userid) {
		$select = $this->getDbTable()->select();
		$select->from('Transaction', array('sum(amount) as balance') )
              ->where('userid = ?', $userid)
       			->group('userid');
       	$rows = $this->getDbTable()->fetchAll($select);
       	
       	if(count($rows) == 0) return 0;
       	return $rows[0]['balance'];	
	}
	
	function getCompleteHistory($userid) {
		$select = $this->getDbTable()->select();
		$select->setIntegrityCheck(false)
			->from('Lesson as l', array(
				'l.date as lesson_date',
				'credit_t.amount as credit_amount',
				'debit_t.amount as debit_amount',
				'c.name as course_name'
			))
			->join('Transaction as credit_t', 'l.credit_transactionid = credit_t.id')
			->join('Transaction as debit_t', 'l.debit_transactionid = debit_t.id')
			->join('Enrolment as e', 'l.enrolmentid = e.enrolmentid')
			->join('Course as c', 'e.courseid = c.id')
			->where('credit_t.userid = ?', $userid)
			->where('debit_t.userid = ?', $userid);
		
		$rowSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
		foreach($rowSet as $row) {
			$entries[] = (object) array(
				"description" => "Lesson (".$row->course_name.")",
				"date" => new Zend_Date($row->lesson_date, Zend_Date::ISO_8601),
				"payment" => $row->credit_amount,
				"cost" => -1 * $row->debit_amount
			);
		}
		
		return $entries;
	}
}