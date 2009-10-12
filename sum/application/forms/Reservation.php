<?php
class Default_Form_Reservation extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
       
        $this->addElement('select', 'terminal', array(
        	'label'	=> 'Terminal:',
        	'required'	=> true
        ));
        
                // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Save',
        ));
        
    }
}