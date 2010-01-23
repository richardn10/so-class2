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

class So_Fileprocessor
{
    /**
     *
     * @var array
     */
    private $_config = array();

    /**
     *
     * @var array
     */

    private $_filetypes = array();

    /**
     *
     * @var array
     */
    private $_actions = array();


    /**
     *
     * @var array
     */
    private $_actionClass = array();

    /**
     *
     * @var array
     */
    private $_actionOptions = array();

    /**
     *
     * @var array
     */
    private $_nextAction = array();

    /**
     *
     * @var int
     */
    const MAX_FAILS = 2;

    /**
     * @param array $config
     * @return void
     */
    public function __construct($config)
    {
        $this->_config = $config;
        $this->_filetypes = array_keys($config);

        foreach($this->_filetypes as $filetype) {
            $this->_actions[$filetype] = array();
            $this->_nextAction[$filetype] = array();
            $this->_actionOptions[$filetype] = array();
            $this->_actionClass[$filetype] = array();
            foreach($config[$filetype] as $actionName => $actionConfig) {
                $this->_actionClass[$filetype][$actionName] = $actionConfig['actionClass'];
                $this->_nextAction[$filetype][$actionName] = strlen(trim($actionConfig['nextAction'])) > 0 ? $actionConfig['nextAction'] : null;
                $this->_actionOptions[$filetype][$actionName] = $actionConfig['options'];
            }

        }
    }

    /**
     * @param Work $work
     * @param string $actionName
     * @return void
     */
    public function processOneAction($work, $actionName)
    {
        if($work->current_pid != getmypid())
            throw new Exception("Work is not claimed!");

        if(!isset($this->_actions[$work->file_type][$actionName])) {
            $this->_loadAction($work->file_type, $actionName);
        }

        $this->_actions[$work->file_type][$actionName]->Act($work);
    }

    /**
     * @param Work $work
     * @return void
     */
    public function claimWork($work)
    {
        $work->current_pid = getmypid();
        $work->save();
    }

    /**
     * @param int $numberOfWorks
     * @return void
     */
    public function claimWorks($numberOfWorks = 1)
    {
        Work::setWorksToPid(getmypid(), $numberOfWorks);
    }

    /**
     * @param Work $work
     * @return void
     */
    public function releaseWork($work)
    {
        $work->current_pid = null;
        $work->save();
    }

    /**
     * @param Work $work
     * @return void
     */
    public function process($work)
    {
        $numFails = 0;
        $lastAction = $work->getLastStatusLine();

        while(!$work->finished && $numFails < self::MAX_FAILS ) {
            if($lastAction->success) {
                if(!is_null($this->_nextAction[$work->file_type][$lastAction->action])) {
                    $this->processOneAction($work,$this->_nextAction[$work->file_type][$lastAction->action]);
                }
                else {
                    $work->finished = true;
                    $work->save();
                }
            } else {
                $this->processOneAction($work,$lastAction->action);
            }

            $lastAction = $work->getLastStatusLine();
            if(!$lastAction->success) ++$numFails;
        }

        $this->releaseWork($work);
    }

    /**
     * @param string $filetype
     * @param string $actionName
     * @return void
     */
    private function _loadAction($filetype, $actionName)
    {
        $actionClass = $this->_actionClass[$filetype][$actionName];
        $classname = 'So_Fileprocessor_Action_'.$actionClass;
        if(isset($this->_actions[$filetype][$actionName])
          && $this->_actions[$filetype][$actionName] instanceof $classname)
            throw new Exception($classname +' already loaded');

        require_once 'So/Fileprocessor/Action/'.$actionClass.'.php';

        $r = new ReflectionClass($classname);

        $this->_actions[$filetype][$actionName] = $r->newInstance();
        $this->_actions[$filetype][$actionName]->setActionName($actionName);
        $this->_actions[$filetype][$actionName]->setOptions($this->_actionOptions[$filetype][$actionName]);
    }

}