<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }
    
    
    protected function _initProfiler()
    {
    	$this->bootstrap('doctrine');
    	$profiler = new So_DoctrineFirebugProfiler('All DB Queries');
    	
    	$this->getResource('doctrine')->setListener($profiler);
    }
    
    protected function _initTimeZone()
    {
        date_default_timezone_set('UTC');
    }
    
    protected function _initUploadProcessor() {
    	return new So_UploadProcessor($this);
    }
    
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML4_STRICT');
    }
    
    protected function _initJQuery()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        ZendX_JQuery::enableView($view);
        $view->jQuery()->setLocalPath('/js/jquery-1.3.2.min.js');
        $view->jQuery()->setVersion('1.3.2');
    }
    
    protected function _initFileprocessor()
    {
    	return new So_Fileprocessor($this->getOption('fileprocessor'));
    }
}

