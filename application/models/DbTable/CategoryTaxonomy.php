<?php

class Application_Model_DbTable_CategoryTaxonomy extends Zend_Db_Table_Abstract
{

    protected $_name = 'category_taxonomy';

    public function fetchCategoryIdsByTransactionId($transactionId){
        
        
        $data = $this->fetchAll(array('transaction_id = ?'=>$transactionId));
        $rtn = array();
        
        if (count($data)>0){
            
            foreach($data AS $segment){
                $rtn[] = $segment->category_id;
            }
            
        }
        
        
        return $rtn;
    }

}

