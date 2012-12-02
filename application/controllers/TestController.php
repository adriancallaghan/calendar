<?php

class TestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        
        $dateArgs = null;
        
        $form = new Application_Form_Transaction();

        $form->setTags(Application_Model_Account_Tags::getAllTags())
            ->setCategories(Application_Model_Account_Categorys::getAllCategories())
            ->setDate(Application_Model_Calendar_Dates::Date($dateArgs));
        
        
        $this->view->form = $form;

    }


}

