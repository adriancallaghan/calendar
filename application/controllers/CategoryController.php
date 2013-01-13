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
               
        $this->forward('show');
        return;
        
    }


    public function showAction(){
        
        // category
        $group = $this->getRequest()->getParam('group');
        $where = $group=='' ? null : array('category_id = ?'=>$group);
        $tags = Application_Model_Account_Tags::fetchAll();
        $this->view->tags = $tags;
    }

}





