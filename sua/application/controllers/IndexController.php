<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
//		if($this->getRequest()->isPost()) {
//			$form = new Form_Upload();
//			
//			if (!$form->isValid($this->getRequest()->getPost())) 
//			{
//			    throw new Exception('Bad data: '.print_r($form->getMessages(), true));
//			}
//			
//			try {
//				$form->file->receive();
//			} 
//			catch (Zend_File_Transfer_Exception $e) 
//			{
//				throw new Exception('Bad data: '.$e->getMessage());
//			}
//			
//			if(is_array($form->file->getFilename())) {
//				foreach($form->file->getFilename() as $key => $filename) {
//					
//					$work = new Model_Work($form->getValue("correlationId"), $filename);
//					$work->save();
//				}
//			} else {
//				$work = new Model_Work($form->getValue("correlationId"), $form->file->getFilename());
//				$work->save();
//			}
//			
////			print_r($form->file->getUnfilteredValue());
////			print_r($form->file->getValue());
//			print_r($form->file->getFilename());
////			print_r($form->file->getFilename());
//				
//			echo "File uploaded";
//		}
//    	
//	
//	
////	if($form->isValid($this->getRequest()->getPost()) && $form->file->receive()) {
////	    echo "Success";
////	}	
////	
//        $this->view->form = new Form_Upload();
    }


}

