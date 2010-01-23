<?php
/**
 * SUA
 *
 * LICENSE
 *
 * This file is part of Switched On Upload Agent (SUA).
 *
 * SUA is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SUA is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SUA.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright (c) 2009-2010 Switched On (International)
 * @author Peter Smit, (peter AT smitmail DOT eu)
 *
 */


require_once 'Doctrine/Connection/Profiler.php';

require_once 'Zend/Wildfire/Plugin/FirePhp.php';
require_once 'Zend/Wildfire/Plugin/FirePhp/TableMessage.php';


class So_DoctrineFirebugProfiler extends Doctrine_Connection_Profiler
{

    /**
     * Label for the output table
     *
     * @var string
     */
    private $_label;

    /**
     * The message class
     *
     * @var Zend_Wildfire_Plugin_FirePhp_TableMessage
     */
    private $_message;

    /**
     * The sum of execution times
     *
     * @var int
     */
    private $_totalElapsedTime;

    /**
     * @param string|null $label
     * @return void
     */
    public function __construct($label = null)
    {
        $this->_label = $label;
        if(!$this->_label) {
            $this->_label = 'So_DoctrineFirebugProfiler';
        }

        $this->_message = new Zend_Wildfire_Plugin_FirePhp_TableMessage($this->_label);
        $this->_message->setBuffered(true);
        $this->_message->setHeader(array('Name','Time','Event','Parameters'));
        $this->_message->setDestroy(true);
        Zend_Wildfire_Plugin_FirePhp::getInstance()->send($this->_message);
    }

    /**
     * @param unknown_type $m
     * @param unknown_type $a
     * @return unknown_type
     */
    public function __call($m, $a)
    {
        // first argument should be an instance of Doctrine_Event
        if ( ! ($a[0] instanceof Doctrine_Event)) {
            throw new Doctrine_Connection_Profiler_Exception("Couldn't listen event. Event should be an instance of Doctrine_Event.");
        }


        if (substr($m, 0, 3) === 'pre') {
            // pre-event listener found
            $a[0]->start();

            $eventSequence = $a[0]->getSequence();
            if ( ! isset($this->eventSequences[$eventSequence])) {
                $this->events[] = $a[0];
                $this->eventSequences[$eventSequence] = true;
            }
        } else {
            // after-event listener found
            $a[0]->end();
            $this->_message->setDestroy(false);
            $this->_totalElapsedTime += $a[0]->getElapsedSecs();
            $row = array($a[0]->getName(),
            round($a[0]->getElapsedSecs(),5),
            $a[0]->getQuery(),
            ($params=$a[0]->getParams())?$params:null);
            $this->_message->addRow($row);
            $this->updateMessageLabel();
        }

    }

    /**
     * @return void
     */
    protected function updateMessageLabel()
    {
        if (!$this->_message) {
            return;
        }
        $this->_message->setLabel($this->_label . ' (' . round($this->_totalElapsedTime,5) . ' sec)');
    }

}