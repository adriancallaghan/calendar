<?php

class Application_Model_DbTable_Tags extends Zend_Db_Table_Abstract
{

    protected $_name = 'tags';

    public function fetchTags($tagNames){
        
        if (!is_array($tagNames)){
            $tagNames = array($tagNames);
        }
        
        $select = $this->select()->where('tag_name IN (?)',$tagNames);
        
        return $this->fetchAll($select);
        
    }
    
    public function fetchTagsById($tagIds){

        
        if ($tagIds==''){
            return null;
        }
        
        if (!is_array($tagIds)){
            $tagIds = array($tagIds);
        }

        if (count($tagIds)==0){
            return null;
        }
        
        $select = $this->select()->where('tag_id IN (?)',$tagIds);
        
        return $this->fetchAll($select);
        
    }
    
}

