<?php

class Default_Model_DbTable_Course extends Zend_Db_Table_Abstract
{
    /** Table name */
    protected $_name    = 'Course';
    protected $_dependentTables = array('Default_Model_DbTable_Enrolment');
}
