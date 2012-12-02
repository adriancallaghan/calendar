<?php

class Application_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{

    protected $_name = 'categories';


    public function fetchCategories($categories){
        
        if (!is_array($categories)){
            $categories = array($categories);
        }
        
        $select = $this->select()->where('category_name IN (?)',$categories);
        
        return $this->fetchAll($select);
        
    }
    
    public function fetchCategoriesById($categoryIds){
        

        if ($categoryIds==''){
            return null;
        }
        
        if (!is_array($categoryIds)){
            $categoryIds = array($categoryIds);
        }
        
        if (count($categoryIds)==0){
            return null;
        }
        

        $select = $this->select()->where('category_id IN (?)',$categoryIds);
        return $this->fetchAll($select);
        
    }
    
    
}

