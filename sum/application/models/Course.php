<?php

class Default_Model_Course extends Default_Model_Abstract {
	protected $_id;
	protected $_name;
	protected $_numberOfLessons;
	protected $_lessonPrice;
	
	protected $_mapper;

    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId() {
    	return $this->_id;
    }
	
	public function setName($text)
    {
        $this->_name = (string) $text;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
    
	public function setNumberOfLessons($num)
    {
        $this->_numberOfLessons = (int) $num;
        return $this;
    }

    public function getNumberOfLessons()
    {
        return $this->_numberOfLessons;
    }
    
	public function setLessonPrice($num)
    {
        $this->_lessonPrice = (int) $num;
        return $this;
    }

    public function getLessonPrice()
    {
        return $this->_lessonPrice;
    }
}