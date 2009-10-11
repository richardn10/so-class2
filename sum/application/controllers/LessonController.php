<?php

class LessonController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function registerAction()
    {
    	$form = new Default_Form_Payment();
    	if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    		$this->_forward('confirm');
    	}
        if(!$this->_hasParam('enrolment')) {
        	$this->_helper->redirector('index', 'index');
        }
        
    	$enrolmentModel = new Default_Model_Enrolment();
    	$enrolment = $enrolmentModel->find($this->_getParam('enrolment'));
    	
        $this->view->enrolment = $enrolment;
        
        
        
        $this->view->form = $form;
        
    }


    public function confirmAction()
    {
    	$form = new Default_Form_Confirm();
    	$form->setAction('/lesson/confirm');
    	$form->addElement('hidden', 'enrolmentid')
    		->addElement('hidden', 'payment');
    			
    	if($this->_hasParam('confirm') && $form->isValid($this->getRequest()->getPost())) {
    		$enrolmentModel = new Default_Model_Enrolment();
    		$enrolment = $enrolmentModel->find($this->_getParam('enrolmentid'));
    		
    		$date = new Zend_Date();
    		
    		$db = $this->getInvokeArg('bootstrap')->getResource('db');
    		$db->beginTransaction();
    		
    		$transactionLessonCost = new Default_Model_Transaction(array(
    			'userId' => $enrolment->user->id,
    			'amount' => -1 * $enrolment->course->lessonPrice,
    			'type' => 'debit_lesson',
    			'date' => $date
    		));
    		
    		$transactionPayment = new Default_Model_Transaction(array(
    			'userId' => $enrolment->user->id,
    			'amount' => $form->getValue('payment'),
    			'type' => 'credit_cash',
    			'date' => $date
    			
    		));
    		
    		$transactionLessonCost->save();
    		$transactionPayment->save();
    		
    		$lesson = new Default_Model_Lesson(array(
    			'enrolmentId' => $enrolment->id,
    			'cost' => $enrolment->course->lessonPrice,
    			'duration' => $enrolment->course->lessonLength,
    			'creditTransactionId' => $transactionPayment->getId(),
    			'debitTransactionId' => $transactionLessonCost->getId(),
    			'date' => $date
    		));
    		$lesson->save();
    		$db->commit();
    		
    		$this->_helper->redirector('view', 'user', array('id' => $enrolment->user->id));
    		
    	} else {
    		$paymentForm = new Default_Form_Payment();
    		if(!$paymentForm->isValid($this->getRequest()->getPost())) {
    			throw new Zend_Exception("I don't like it that you try to hack me :( ");
    		}
    		

    		$form->setDefaults(array
    			('enrolmentid' => $this->_getParam('enrolment'), 
    			'payment' => $paymentForm->getValue('amount')));
    		
    		$enrolmentModel = new Default_Model_Enrolment();
    		$enrolment = $enrolmentModel->find($this->_getParam('enrolment'));
    		
    		$this->view->payment = $paymentForm->getValue('amount');
        	$this->view->enrolment = $enrolment;
    		$this->view->form = $form;
    	}

    }
    
}



