<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->headScript()->appendFile('/assets/js/js.js','text/javascript');
        $this->view->headLink()->appendStylesheet('/assets/css/reset.css');
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
        // action body
        

        $showCache = false;
        
        if ($showCache){
            echo '<pre>';
            //apc_clear_cache('user');
            print_r(apc_cache_info('user'));
            die;
        }
        
        // todays date, or requested date
        $curr_date = Application_Model_Calendar_Dates::Date(array('unix'=>$this->getRequest()->getParam('date')));
        
        
        // get period of dates
        $dates = Application_Model_Calendar_Dates::query(
                Application_Model_Calendar_Dates::getCalendarMonthStartDate($curr_date), 
                Application_Model_Calendar_Dates::getCalendarMonthEndDate($curr_date)
                );
        
        
        // statement
        $statement = Application_Model_Account_Statement::query($dates, false);
        $this->view->statement = $statement;
 
        // current date
        $this->view->current_date = $curr_date;
        
        
    }


}

