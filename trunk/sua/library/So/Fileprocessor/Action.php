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

abstract class So_Fileprocessor_Action
{
    protected $_actionName;
    protected $_work;
    protected $_options;

    protected $_statusLine;
    protected $_success;
    protected $_message;
    protected $_resultUrl;

    public function setActionName($actionName)
    {
        $this->_actionName = $actionName;
    }

    public function setOptions($options)
    {
        $this->_options = $options;
    }

    protected function _preAction($work)
    {
        $this->_statusLine = new StatusLine();
        $this->_success = false;
        $this->_message = null;
        $this->_resultUrl = null;

        $this->_statusLine->process_id = getmypid();
        $this->_statusLine->action = $this->_actionName;
        $this->_statusLine->event_start = date('Y-m-d H:i:s');

        $this->_statusLine->link('Work', $work->id);
        $this->_statusLine->save();
    }

    public function Act($work)
    {
        $this->_preAction($work);
        try {
            $this->_doAction($work);
        } catch(Exception $e) {
            $this->_success = false;
            $this->_message = $e->getMessage();
        }
        $this->_postAction();
    }

    protected abstract function _doAction($work);

    protected function _postAction()
    {
        $this->_statusLine->event_end = date('Y-m-d H:i:s');
        $this->_statusLine->finished = true;
        $this->_statusLine->success = $this->_success;
        $this->_statusLine->message = $this->_message;
        $this->_statusLine->result_url = $this->_resultUrl;
        $this->_statusLine->save();
    }

}