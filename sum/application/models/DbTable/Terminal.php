<?php
class Default_Model_DbTable_Terminal extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name    = 'Terminal';
	
	protected $_dependentTables = array('Default_Model_DbTable_TerminalReservation');

}