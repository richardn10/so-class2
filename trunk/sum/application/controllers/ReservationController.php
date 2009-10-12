<?php

class ReservationController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		// action body
	}

	public function editAction()
	{
		if(!$this->_hasParam('id')) {
			return $this->_helper->redirector('index', 'index');
		}
		 
		$form = new Default_Form_Reservation();

		$reservationModel = new Default_Model_TerminalReservation();
		$reservation = $reservationModel->find($this->_getParam('id'));
		 
		$terminalModel = new Default_Model_Terminal();
		$terminals = $terminalModel->getUnreservedTerminals(0);
		$selectOptions = array();
		foreach($terminals as $terminal) $selectOptions[$terminal->id] = $terminal->name;
		 
		$selectOptions[$reservation->terminal->id] = $reservation->terminal->name;
		 
		$form->getElement('terminal')->setMultiOptions($selectOptions);
		if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
			$reservation->terminalId = $form->getValue('terminal');
			$reservation->save();
			$this->_helper->FlashMessenger('The terminal was changed');
			return $this->_helper->redirector('index', 'terminal');
		}
		 
		$form->getElement('terminal')->setValue($reservation->terminalId);
		$this->view->reservation = $reservation;
		$this->view->form = $form;
	}

	public function clearAction()
	{
		if(!$this->_hasParam('id')) {
			return $this->_helper->redirector('index', 'index');
		}    
		
		$form = new Default_Form_Confirm();

		$reservationModel = new Default_Model_TerminalReservation();
		$reservation = $reservationModel->find($this->_getParam('id'));
		
		if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
			$reservation->setCancelled(true);
			$reservation->save();
			$this->_helper->FlashMessenger('The reservation was cancelled');
			return $this->_helper->redirector('index', 'terminal');
		}
		
		$this->view->reservation = $reservation;
		$this->view->form = $form;
	}


}





