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
        
        die('BROKEN');
        $dateArgs = null;
        
        $form = new Application_Form_Transaction();

        $form->setTags(Application_Model_Account_Tags::getAllTags())
            ->setCategories(Application_Model_Account_Categorys::getAllCategories())
            ->setDate(Application_Model_Calendar_Dates::Date($dateArgs));
        
        
        $this->view->form = $form;
        
        
        $state = array();
        
        $input = new Application_Form_Transaction();
        $input->setTags(Application_Model_Account_Tags::getAllTags())
            ->setCategories(Application_Model_Account_Categorys::getAllCategories());
        
        
        if (!$input->isValid($this->getRequest()->getParams())){
            $state = $input->getErrors();
        } else {
            
            $state = array(
                'success'=>Application_Model_Account_Transactions::newTransaction($input->getTransaction(), $input->getDate())
                );
        }
        
        print_r($state);
        die;
        
        
    }


}





