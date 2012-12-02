<?php

class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function savetransactionAction()
    {
        /*
         * saves a transaction to a date
         */
        
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



