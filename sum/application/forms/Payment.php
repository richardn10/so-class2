<?php
class Default_Form_Payment extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
       
        $this->addElement('text', 'amount', array(
            'label'      => 'Payment Received (Rp):',
            'required'   => true,
            'validators' => array(
				array('NotEmpty', true),
			    array('Float', true),
			    array('GreaterThan', true, array(min => -0.0001))
    		)
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Register',
        ));

    }
}
