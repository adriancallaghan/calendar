<?php


class Application_Model_Account_Categorys implements Iterator{
    

    use Application_Model_Trait_Iterable;
    


    private function __construct()
    {     
        $this->rewind(); // reset the pointer
        
    }
     
    public function setCategories(array $categorys){
        
        $this->setData($categorys);
        return $this;
    }
    
    public function getCategories(){
        
        return $this->getData();
    }
    
    private function setCategory(Zend_Db_Table_Row $category){
        
        $categories = $this->getCategories();
        $categories[] = $category;
        $this->setCategories($categories);
        return $this;
    }
    
    public static function getAllCategories(){

        $categoriesObj = new Application_Model_DbTable_Categories();
        $thisObj = new Application_Model_Account_Categorys();

        $categories = $categoriesObj->fetchAll();
        if ($categories){
            foreach ($categories AS $category){

                $thisObj->setCategory($category);

            }
        }
         
        return $thisObj;
    }
    
    public static function getCategoriesByNames($categoryNames = null){
        
        $categoriesObj = new Application_Model_DbTable_Categories();
        $thisObj = new Application_Model_Account_Categorys();
        
        $categories = $categoriesObj->fetchCategories($categoryNames);
        
        if ($categories){
            foreach ($categories AS $category){
                $thisObj->setCategory($category);
            }
        }
            
        return $thisObj;
        
    }

    public static function getCategoriesByIds($categoryIds = null){
        
        $categoriesObj = new Application_Model_DbTable_Categories();
        $thisObj = new Application_Model_Account_Categorys();
        
        $categories = $categoriesObj->fetchCategoriesById($categoryIds);
        
        if ($categories){
            foreach ($categories AS $category){
                $thisObj->setCategory($category);
            }
        }
            
        return $thisObj;
        
    }
    
    public static function getCategoriesByTransactionId($transactionId){
        
        $categoryTaxObj = new Application_Model_DbTable_CategoryTaxonomy();
        $categoryObj = new Application_Model_DbTable_Categories();
        $thisObj = new Application_Model_Account_Categorys();
        
        
        $taxonomyIds = $categoryTaxObj->fetchCategoryIdsByTransactionId($transactionId);
        if (count($taxonomyIds)>0){

            $categorys = $categoryObj->fetchCategoriesById($taxonomyIds);

            if ($categorys){
                foreach ($categorys AS $category){
                            
                    $thisObj->setCategory($category);
                    
                }
            }
            
        }
        
        return $thisObj;
    }
    
    public static function setCategoriesByTransactionId($transactionId, Application_Model_Account_Categorys $categories){
        
        $catTaxObj = new Application_Model_DbTable_CategoryTaxonomy();
        
        // clear existing categories
        $catTaxObj->delete(array('transaction_id = ?'=>$transactionId));
        
        if (!count($categories)>0){
            return;
        }
        
        foreach ($categories AS $cat){
            $catTaxObj->insert(array('transaction_id'=>$transactionId,'category_id'=>$cat->category_id));
        }
        
    }
    
}

?>
