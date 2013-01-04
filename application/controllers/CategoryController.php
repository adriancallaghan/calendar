<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->headScript()->appendFile('/assets/js/js.js','text/javascript');
        $this->view->headLink()->appendStylesheet('/assets/css/style.css');
        $this->view->headMeta()
            ->appendName('keywords', 'Calendar, Tags, Categories')
            ->appendHttpEquiv('expires','Wed, 26 Feb 1997 08:21:57 GMT')
            ->appendHttpEquiv('pragma', 'no-cache')
            ->appendHttpEquiv('Cache-Control', 'no-cache')
            ->appendHttpEquiv('Content-Type','text/html; charset=UTF-8')
            ->appendHttpEquiv('Content-Language', 'en-UK');
        $this->view->headTitle('Calendar');
    }

    public function indexAction()
    {
               
                // category
        $curr_categorys = Application_Model_Account_Categorys::getCategoriesByIds($this->getRequest()->getParam('category'));
   
        
    }

    public function editAction()
    {
        // action body
    }

    public function createAction()
    {
        // action body
    }


}





