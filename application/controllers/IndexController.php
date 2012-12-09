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
        $curr_date = Application_Model_Calendar_Dates::Date(array('unix'=>$this->getRequest()->getParam('date')));
        
        // category
        $curr_categorys = Application_Model_Account_Categorys::getCategoriesByIds($this->getRequest()->getParam('category'));

        // tag
        $curr_tags = Application_Model_Account_Tags::getTagsByIds($this->getRequest()->getParam('tag'));
        
        // get period of dates
        $dates = Application_Model_Calendar_Dates::query(
                Application_Model_Calendar_Dates::getCalendarMonthStartDate($curr_date), 
                Application_Model_Calendar_Dates::getCalendarMonthEndDate($curr_date)
                );
        
        
        // statement
        $statement = Application_Model_Account_Statement::query($dates, false);
        $statement->addFilters($curr_categorys);
        $this->view->statement = $statement;
 
        // current date
        $this->view->current_date = $curr_date;
        
        // current category
        $this->view->current_categorys = $curr_categorys;
        
        // current tag
        $this->view->current_tags = $curr_tags;
        
    }


}

