<?php

class Form_Upload extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'UTF-8');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('id', 'uploadform');

        $this->addElement('file', 'file', array(
            'label'       => 'File to upload:',
            'validators'  => array(
                                array('Count', false, array('min' =>1, 'max' => 1)),
                                array('Size', false, array('max' => '2000MB')),
                             ),
            'filters'	  => array(
        	'Rename'      => array('target' => APPLICATION_PATH. '/../data/uploads/'),
        ),
        ));

        $this->addElement('submit', 'filesubmit', array(
            'ignore'   => true,
            'label'    => 'Save',
        ));

        $this->addElement('reset', 'cancel', array(
            'ignore'   => true,
            'label'    => 'Cancel',
        ));
    }
}
