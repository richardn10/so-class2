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

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }

    /**
     * @return void
     */
    protected function _initProfiler()
    {
        if($this->getEnvironment() == 'development') {
            $this->bootstrap('doctrine');
            $profiler = new So_DoctrineFirebugProfiler('All DB Queries');

            $this->getResource('doctrine')->setListener($profiler);
        }
    }

    /**
     * @return void
     */
    protected function _initTimeZone()
    {
        date_default_timezone_set('UTC');
    }

    /**
     * @return void
     */
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML4_STRICT');
    }

    /**
     * @return void
     */
    protected function _initJQuery()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        ZendX_JQuery::enableView($view);
        $view->jQuery()->setLocalPath('/js/jquery-1.3.2.min.js');
        $view->jQuery()->setVersion('1.3.2');
    }

    /**
     * @return So_Fileprocessor
     */
    protected function _initFileprocessor()
    {
        return new So_Fileprocessor($this->getOption('fileprocessor'));
    }
}

