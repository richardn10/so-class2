<?php

class UserController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$users = new Default_Model_User();
		$this->view->users = $users->fetchAll();
	}

	public function addAction()
	{
		$request = $this->getRequest();
		$form    = new Default_Form_User();

//		$form->getElement('username')->addValidator(
//        'Db_NoRecordExists', true, array(
//        	'table' => 'User', 
//        	'field' => 'username'
//        	)
//        );
        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$user = new Default_Model_User($form->getValues());
        		$user->save();
        		$this->_helper->FlashMessenger('User created');
        		return $this->_helper->redirector('view', 'user','default',array('id' => $user->id) );
        	}
        }

        $this->view->form = $form;
	}

	public function searchAction()
	{
		$request = $this->getRequest();
		$form    = new Default_Form_SearchUser();

		$model = new Default_Model_User();
		if ($form->isValid($request->getQuery())) {
			$values = $form->getValues();
			$users = $model->findByAnyField($values['name']);
		}
		else {
			$users = $model->fetchAll();
		}

		$this->view->users = $users;

		if(!$this->_hasParam('submit')) {
			$form = new Default_Form_SearchUser();
		}
		$this->view->form = $form;
	}

	public function viewAction()
	{
		if ($this->_hasParam('id')) {
			$userid = $this->_getParam('id');
		} else {
			return $this->_helper->redirector('index');
		}
		 
		$model = new Default_Model_User();
		$user = $model->find($userid);

		$this->view->user = $user;
		$this->view->enrolments = $user->fetchNotFinishedEnrolmentCourses();
		$this->view->finishedEnrolments = $user->fetchFinishedEnrolmentCourses();
		$this->view->unEnrolledCourses = $user->fetchUnEnrolledCourses();
		
		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
	}

	public function editAction()
	{
		$request = $this->getRequest();
		$form    = new Default_Form_User();
		$form->addElement('hidden', 'id', array());

		$id = $this->_getParam('id');

//		$form->getElement('username')->addValidator(
//        	'Db_NoRecordExists', true, array(
//        		'table' => 'User', 
//        		'field' => 'username',
//        		'exclude' => array(
//        			'field' => 'id',
//        			'value' => $id)
//				)
//		);
		$model = new Default_Model_User();
		$origUser = $model->find($id);
		
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				$origUser->setFirstName($form->getValue('firstname'));
				$origUser->setLastName($form->getValue('lastname'));
//				$user = new Default_Model_User($form->getValues());
//				$user->setUsername($origUser->userName);
				$origUser->save();
				$this->_helper->FlashMessenger('User saved');
				$this->_helper->redirector('view', 'user','default',array('id' => $form->getValue('id')) );
			}
			 
		}
		else {
			$userarr = array (
        				'id' => $origUser->getId(),
        				'firstname' => $origUser->getFirstname(),
        				'lastname' => $origUser->getLastname()
			);
			$form->setDefaults($userarr);
		}
		$this->view->user = $origUser;
		$this->view->form = $form;
	}

	public function transactionhistoryAction()
	{
		if ($this->_hasParam('id')) {
			$userid = $this->_getParam('id');
		} else {
			return $this->_helper->redirector('index');
		}
		 
		$model = new Default_Model_User();
		$user = $model->find($userid);

		$this->view->user = $user;

		$this->view->historylines = $user->getTransactionHistory();

	}


}











