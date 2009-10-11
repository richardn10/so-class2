<?php

class Default_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    /** Table name */
    protected $_name    = 'User';
    protected $_dependentTables = array('Default_Model_DbTable_Enrolment', 'Default_Model_DbTable_Transaction');
}
