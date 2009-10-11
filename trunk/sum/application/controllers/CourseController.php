<?php

class CourseController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $usermodel = new Default_Model_User();
        //        $user = $usermodel->find(1);
                $dbTable = $usermodel->getMapper()->getDbTable();
                $rowSet = $dbTable->find(1);
                $row = $rowSet->current();
                $result = $row->findDefault_Model_DbTable_CourseViaDefault_Model_DbTable_Enrolment();
                $this->view->result = $result;
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
        	$this->_helper->redirector('view', 'user', array('id' => $enrolment->userId));
        	
        } else {
        	$this->view->user = $user;
        	$this->view->course = $course;
        	$this->view->form = $form;
        }
    }


}



