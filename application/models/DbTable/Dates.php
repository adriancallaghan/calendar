<?php

class Application_Model_DbTable_Dates extends Zend_Db_Table_Abstract
{

    protected $_name = 'dates';


    public function getDbKey(Application_Model_Calendar_Date $date){
        
        $dateDb = $this->fetchRow(array('date_key = ?'=>$date->systemKey));
         
        if (!$dateDb){
             // no such date
             return false;
        }
        
        return $dateDb->date_id;
    }
}

