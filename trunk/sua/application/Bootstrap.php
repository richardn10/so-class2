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
    
    public function _initDoctrine()
    {
    	require_once('Doctrine/Core.php');
    	$this->getApplication()->getAutoloader()
             ->pushAutoloader(array('Doctrine_Core', 'autoload'));
        spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));
        
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(
          Doctrine_Core::ATTR_MODEL_LOADING,
          Doctrine_Core::MODEL_LOADING_CONSERVATIVE
        );
        $manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        $doctrineConfig = $this->getOption('doctrine');

        Doctrine_Core::loadModels($doctrineConfig['models_path']);
       
        $conn = Doctrine_Manager::connection($doctrineConfig['dsn'],'doctrine');
        $conn->setAttribute(Doctrine_Core::ATTR_USE_NATIVE_ENUM, true);
     return $conn;
    }
    

}

