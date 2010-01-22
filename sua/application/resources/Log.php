<?php

class So_Resource_Log extends Zend_Application_Resource_ResourceAbstract
{
    private $_writers;
    private $_log;

    public function setWriter($writer)
    {
        if(is_array($writer) && isset($writer['type']))
            $this->_writers = array($writer);
        else 
            $this->_writers = $writer;
    }

    public function addWritersToLog($logger)
    {
        foreach($this->_writers as $writer) {
            if(isset($writer['type']) && isset($writer['param'])) {
                $l = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../logs/application/standard.log");
                $logger->addWriter(new $writer['type']($writer['param']));
            } elseif(isset($writer['type'])) {
                $logger->addWriter(new $writer['type']());
            }
        }
    }

    public function getLog()
    {
        if(null === $this->_log) {
            $this->_log = new Zend_Log();
            $this->addWritersToLog($this->_log);
        }

        return $this->_log;
    }

    public function init()
    {
        return $this->getLog();
    }


}