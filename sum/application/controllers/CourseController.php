<?php

class CourseController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $courseModel = new Default_Model_Course();
        		$this->view->courses = $courseModel->fetchAll();
    }

    public function enrollAction()
    {
        if(!$this->_hasParam('user') || !$this->_hasParam('course')) {
        			throw new Zend_Exception("No user or course given");
        }
         
        $userModel = new Default_Model_User();
        $user = $userModel->find($this->_getParam('user'));
        
        $courseModel = new Default_Model_Course();
        $course = $courseModel->find($this->_getParam('course'));
        
        $form = new Default_Form_Confirm();
        
        if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        	$enrolment = new Default_Model_Enrolment(array(
                        'userId' => $user->getId(),
                        'courseId' => $course->getId(),
                        'enrolmentDate' => new Zend_Date()
        	));
        	$enrolment->save();
        	$this->_helper->FlashMessenger('User enrolled');
        	$this->_helper->redirector('view', 'user', array('id' => $user->id));
        	 
        } else {
        	$this->view->user = $user;
        	$this->view->course = $course;
        	$this->view->form = $form;
        }
    }

    public function viewAction()
    {
        if(!$this->_hasParam('id')) {
        	return $this->_helper->redirector('index', 'index');
        }
        
        $courseModel = new Default_Model_Course();
        $course = $courseModel->find($this->_getParam('id'));
        
        $this->view->course = $course;
        $this->view->messages = $this->_helper->FlashMessenger->getMessages();
    }

    public function finishAction()
    {
        if($this->_hasParam('id')) {
        	$form = new Default_Form_Confirm();
        	
        	$enrolmentModel = new Default_Model_Enrolment();
        	$enrolment = $enrolmentModel->find($this->_getParam('id'));
        	
        	if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        		$date = Zend_Date::now();
        		$enrolment->setFinishDate($date);
        		$enrolment->save();
        		$this->_helper->FlashMessenger('Enrolment finished');
        		return $this->_helper->redirector('view', 'user', 'default',array('id' => $enrolment->userId));
        	} else {
        		$enrolments = array();
        		$enrolments[] = $enrolment;
        		$this->view->enrolments = $enrolments;
        		$this->view->form = $form;
        	}
        	
        }
    }


}







