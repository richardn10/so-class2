<?php

class Form_Upload extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'UTF-8');
		$this->setAttrib('enctype', 'multipart/form-data');
		
//		$this->addElement('text', 'correlationId', array(
//			'label'      => 'Correlation Id:',
//			'required'   => true,
//			'validators' => array(
//				array('Int', false),
//			),
//		));
		
        $this->addElement('file', 'file', array(
            'label'       => 'File to upload:',
//            'multiFile'   => 6,
            'validators'  => array(
        		array('Count', false, array('min' =>1, 'max' => 1)),
        		array('Size', false, array('max' => '500MB')),
            ),
            'filters'	  => array(
        		'Rename' => array('target' => APPLICATION_PATH. '/../data/uploads/'),
        	 ),
        ));

		$this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Save',
        ));
    }
}
