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
		
		$form->getElement('username')->addValidator(
			'Db_NoRecordExists', true, array(
				'table' => 'User', 
				'field' => 'username'
					)
				);
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Default_Model_User($form->getValues());
				$model->save();
				return $this->_helper->redirector('index');
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
		$this->view->form = new Default_Form_SearchUser();
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
		
		$this->view->enrolments = $user->fetchEnrolmentCourses();
	}

	public function editAction()
	{
		$request = $this->getRequest();
		$form    = new Default_Form_User();
		$form->addElement('hidden', 'id', array());
		
		$id = $this->_getParam('id');
		
		$form->getElement('username')->addValidator(
			'Db_NoRecordExists', true, array(
				'table' => 'User', 
				'field' => 'username',
				'exclude' => array(
					'field' => 'id',
					'value' => $id)
					)
				);
		$model = new Default_Model_User();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				$model = new Default_Model_User($form->getValues());
				$model->save();
				$this->_helper->redirector('view', 'user','default',array('id' => $form->getValue('id')) );
			}
			
		}
		else {
				
			$user = $model->find($id);
			$userarr = array (
				'id' => $user->getId(),
				'username' => $user->getUsername(),
				'firstname' => $user->getFirstname(),
				'lastname' => $user->getLastname()
			);
			$form->setDefaults($userarr);
		} 
		$this->view->form = $form;
	}


}









