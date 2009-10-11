<?php
class Default_Model_DbTable_Lesson extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name    = 'Lesson';
	
	protected $_referenceMap    = array(
        'Enrolment' => array(
            'columns'           => 'enrolmentid',
            'refTableClass'     => 'Default_Model_DbTable_Enrolment',
		)
	);

}