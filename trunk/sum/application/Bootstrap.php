<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }
	
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML4_STRICT');
    }
    
    protected function _initProfiler()
    {
    	$profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
		$profiler->setEnabled(true);
		
		// Attach the profiler to your db adapter
		$resource = $this->getPluginResource('db');
		
		$dbAdapter = $resource->getDbAdapter();
		$dbAdapter->setProfiler($profiler);
    }
    
    protected function _initTimeZone()
    {
    	date_default_timezone_set('UTC');
    }
}

