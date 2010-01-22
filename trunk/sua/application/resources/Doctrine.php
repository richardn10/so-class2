<?php
class So_Resource_Doctrine extends Zend_Application_Resource_ResourceAbstract 
{	
	public function init() 
	{
		require_once('Doctrine/Core.php');
    	$this->getBootstrap()->getApplication()->getAutoloader()
             ->pushAutoloader(array('Doctrine_Core', 'autoload'));
        spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));
        
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(
            Doctrine_Core::ATTR_MODEL_LOADING,
            Doctrine_Core::MODEL_LOADING_CONSERVATIVE
        );
        $manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        Doctrine_Core::loadModels($this->_options['models_path']);
       
        $conn = Doctrine_Manager::connection($this->_options['dsn'],'doctrine');
        
        $conn->setAttribute(Doctrine_Core::ATTR_USE_NATIVE_ENUM, true);
        
     	return $conn;
	}
}