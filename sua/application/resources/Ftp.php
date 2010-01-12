<?php 
class So_Resource_Ftp extends Zend_Application_Resource_ResourceAbstract {
	
	/**
    * @var So_Ftp
    */
	protected $_ftp;

    /**
     * Parameters to use
     *
     * @var array
     */
	protected $_params = array();
	
    public function setParams(array $params)
    {
        $this->_params = $params;
        return $this;
    }
    
   	public function getFtp()
    {
        if (null === $this->_ftp) {
            $this->_ftp = new So_Ftp($this->_params);
        }
        return $this->_ftp;
    }
    /**
    * @return So_Ftp|null
    */
    public function init()
    {
		return $this->getFtp();
    }
}