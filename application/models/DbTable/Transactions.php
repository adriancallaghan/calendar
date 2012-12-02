<?php

class Application_Model_DbTable_Transactions extends Zend_Db_Table_Abstract
{

    protected $_name = 'transactions';

    
     
    
    public function fetchTransaction($id = null){
        
        
        if ($id == null){
            return false;
        }
                       
        return $this->fetchRow(array('id = ?'=>$id));
        
    }
    
    
    public function fetchTransactions($ids = null){
        
        
        if ($ids == null){
            return false;
        }
        
        if (!is_array($ids)){
            $ids = array($ids);
        }
        
        
        $select = $this->select()->where('id IN (?)',$ids);
        
        return $this->fetchAll($select);
        
    }
    
    

}

