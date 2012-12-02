<?php

class Application_Model_DbTable_DateTaxonomy extends Zend_Db_Table_Abstract
{

    protected $_name = 'date_taxonomy';

    
    public function fetchTransactions($dateIds = null){
        
        if (!is_array($dateIds)){
            $dateIds = array($dateIds);
        }
        
        $select = $this->select()->where('date_id IN (?)',$dateIds);

        return $this->fetchAll($select);
        
    }
    

    public function findId($dateId, $transactionId){
        
    }

}

