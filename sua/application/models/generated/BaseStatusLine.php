<?php

/**
 * BaseStatusLine
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $work_id
 * @property integer $process_id
 * @property string $action
 * @property string $result_url
 * @property timestamp $event_start
 * @property timestamp $event_end
 * @property boolean $finished
 * @property boolean $success
 * @property string $message
 * @property Work $Work
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseStatusLine extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('status_line');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('work_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('process_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('action', 'string', 30, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '30',
             ));
        $this->hasColumn('result_url', 'string', 300, array(
             'type' => 'string',
             'length' => '300',
             ));
        $this->hasColumn('event_start', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('event_end', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('finished', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             'notnull' => true,
             ));
        $this->hasColumn('success', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             'notnull' => true,
             ));
        $this->hasColumn('message', 'string', 300, array(
             'type' => 'string',
             'length' => '300',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Work', array(
             'local' => 'work_id',
             'foreign' => 'id'));
    }
}