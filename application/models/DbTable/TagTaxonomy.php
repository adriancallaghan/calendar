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
    
    public function fetchTransactionIdsByTags(Application_Model_Account_Tags $tagsObj){
        
        
         
        $tagIds = array();
        $tags = $tagsObj->getData();
        if (!empty($tags)){
            foreach($tags AS $tag){
                $tagIds[] = $tag->tag_id;
            }
        }


        
        $select = $this->select()->where('tag_id IN (?)',$tagIds);
        
        $data = $this->fetchAll($select);
        $rtn = array();
        
        if (count($data)>0){
            
            foreach($data AS $segment){
                $rtn[] = $segment->transaction_id;
            }
            
        }
        
        return $rtn;
    }
}

