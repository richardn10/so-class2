<?php

class TerminalController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$terminalModel = new Default_Model_Terminal();
		$this->view->terminals = $terminalModel->getTerminalStatusses();
		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
	}

	public function addAction()
	{
		$form = new Default_Form_Terminal();
		$form->getElement('name')->addValidator(
        	'Db_NoRecordExists', true, array(
        		'table' => 'Terminal', 
        		'field' => 'name'
        	)
       	);
        if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        	$terminal = new Default_Model_Terminal($form->getValues());
        	$terminal->save();
        	return $this->_helper->redirector('index');
        }
        $this->view->form = $form;
	}

	public function editAction()
	{
		$request = $this->getRequest();
		$form    = new Default_Form_Terminal();
		$form->addElement('hidden', 'id', array());

		$id = $this->_getParam('id');

		$form->getElement('name')->addValidator(
        	'Db_NoRecordExists', true, array(
        		'table' => 'Terminal', 
        		'field' => 'name',
        		'exclude' => array(
        			'field' => 'id',
        			'value' => $id)
		)
		);

		if ($this->getRequest()->isPost() && $form->isValid($request->getPost())) {
			
			$terminal = new Default_Model_Terminal($form->getValues());
			$terminal->save();
			$this->_helper->redirector('view', 'terminal','default',array('id' => $form->getValue('id')) );
		}
		else {
			$terminalModel = new Default_Model_Terminal();

			$terminal = $terminalModel->find($id);
			$terminalArr = array (
        		'id' => $terminal->getId(),
        		'name' => $terminal->getName()
			);
			$form->setDefaults($terminalArr);
		}
		$this->view->form = $form;
	}

	public function viewAction()
	{
		if ($this->_hasParam('id')) {
			$terminalid = $this->_getParam('id');
		} else {
			return $this->_helper->redirector('index');
		}
		 
		$terminalModel = new Default_Model_Terminal();
		$terminal = $terminalModel->find($terminalid);

		$this->view->terminal = $terminal;
	}

}







