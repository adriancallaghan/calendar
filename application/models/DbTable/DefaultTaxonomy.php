<?php

class Application_Model_DbTable_DefaultTaxonomy extends Zend_Db_Table_Abstract
{

    protected $_name = 'default_taxonomy';


    public function getIds(Application_Model_Calendar_Date $date){

        /*
         * this will accept a date object, it will query the database for the day of the week, and the date of the month
         * 
         * for now it returns all
         * 
         * 
         * example
         * 
         * DATE->DOM 
         * 
         * DATE-.ISFRIDAY ETC
         * 
         * 
         */
        
        $ids = array();
        
        foreach($this->fetchAll(array('active = 1')) AS $entry){
            
            $ids[] = $entry->transaction_id;
        }
        
        return $ids;

    }
    

}

