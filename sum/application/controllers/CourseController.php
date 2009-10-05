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


}

