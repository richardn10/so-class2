<?php

class Default_Model_DbTable_Enrolment extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name    = 'Enrolment';
	protected $_primary = 'enrolmentid';
	protected $_dependentTables = array('Default_Model_DbTable_Lesson');

	protected $_referenceMap    = array(
        'User' => array(
            'columns'           => 'userid',
            'refTableClass'     => 'Default_Model_DbTable_User',
	),
        'Course' => array(
            'columns'           => 'courseid',
            'refTableClass'     => 'Default_Model_DbTable_Course',
	)
	);

}
