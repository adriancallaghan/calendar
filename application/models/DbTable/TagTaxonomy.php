<?php

class Application_Model_DbTable_TagTaxonomy extends Zend_Db_Table_Abstract
{

    protected $_name = 'tag_taxonomy';

    
    public function fetchTagIdsByTransactionId($transactionId){
        
        $data = $this->fetchAll(array('transaction_id = ?'=>$transactionId));
        $rtn = array();
        
        if (count($data)>0){
            
            foreach($data AS $segment){
                $rtn[] = $segment->tag_id;
            }
            
        }
        
        return $rtn;
    }
}

