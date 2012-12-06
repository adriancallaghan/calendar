<?php

class TransactionController extends Zend_Controller_Action
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
        // action body
        
        $requestedTransactionId = $this->getRequest()->getParam('arg1');
        
        $transaction = Application_Model_Account_Transactions::fetchByTransactionId($requestedTransactionId);
        
        if ($transaction->id!==$requestedTransactionId){
            throw new Exception('Invalid Transaction Id '.$requestedTransactionId);
        }
        

        $form = new Application_Form_Transaction();
        $form
            ->setTags(
                    Application_Model_Account_Tags::getAllTags()
                    )
            ->setCategories(
                    Application_Model_Account_Categorys::getAllCategories()
                    )
                ->populateByTransaction($transaction);

        
        
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams())){

            Application_Model_Account_Transactions::updateTransaction($form->getTransaction());

        }
        
        
        
        
        $this->view->form = $form;
    }

    public function createAction()
    {
        // action body
        
        $dateReq = $this->getRequest()->getParam('arg1');
        $dateObj = Application_Model_Calendar_Dates::Date(array('unix'=>$dateReq));
        if ($dateObj->unix !== $dateReq){
            throw new Exception('Invalid date specified');
        }



        $form = new Application_Form_Transaction();
        $form
            ->setTags(
                    Application_Model_Account_Tags::getAllTags()
                    )
            ->setCategories(
                    Application_Model_Account_Categorys::getAllCategories()
                    );

        
        
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams())){

            Application_Model_Account_Transactions::newTransaction($form->getTransaction(), $dateObj);
        }
        
        
         $this->view->form = $form;
        
    }


}





