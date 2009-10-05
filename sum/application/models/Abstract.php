<?php

class Default_Model_Abstract {

	protected $_mapperClass;
	
	protected $_mapper;
	protected $_row;
	
	public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || ('row' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ('row' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
       
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new $this->_mapperClass());
        }
        return $this->_mapper;
    }
    
    public function setRow($row)
    {
        $this->_row = $row;
        return $this;
    }

    public function getRow()
    {
        return $this->_row;
    }

    public function save()
    {
        $this->getMapper()->save($this);
    }
   
	public function find($id)
	{
		$this->getMapper()->find($id, $this);
        return $this;
	}
	
	public function findByAnyField($needle)
	{
		return $this->getMapper()->findByAnyField($needle);
	}
	
	public function fetchAll()
	{
		return $this->getMapper()->fetchAll();
	}

}