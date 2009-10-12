<?php
class Default_Model_DbTable_TerminalReservation extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name    = 'TerminalReservation';
	
	protected $_referenceMap    = array(
        'Terminal' => array(
            'columns'           => 'terminalid',
            'refTableClass'     => 'Default_Model_DbTable_Terminal',
		),
		'User' => array(
            'columns'           => 'userid',
            'refTableClass'     => 'Default_Model_DbTable_User',
		)
	);

}