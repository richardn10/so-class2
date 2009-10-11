<?php
class Default_Form_Confirm extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
       

        // Add the submit button
        $this->addElement('submit', 'confirm', array(
            'ignore'   => true,
            'label'    => 'Confirm',
        ));

    }
}