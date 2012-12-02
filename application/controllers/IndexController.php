<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
        $curr_date = Application_Model_Calendar_Dates::Date();
        
        // get period of dates
        $dates = Application_Model_Calendar_Dates::query(
                Application_Model_Calendar_Dates::getCalendarMonthStartDate($curr_date), 
                Application_Model_Calendar_Dates::getCalendarMonthEndDate($curr_date)
                );
        
        
        // statement
        $this->view->statement = Application_Model_Account_Statement::query($dates, false);

        // current date
        $this->view->current_date = $curr_date;

    }


}

