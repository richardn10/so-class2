<?php

class Default_Form_User extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttrib('accept-charset', 'UTF-8');
        
        $this->addElement('text', 'firstname', array(
            'label'      => 'First Name:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(1, 30))
                )
        ));
        
        $this->addElement('text', 'lastname', array(
            'label'      => 'Last Name:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(1, 30))
                )
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Save',
        ));

    }
}
