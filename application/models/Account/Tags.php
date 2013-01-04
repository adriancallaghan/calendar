<?php


class Application_Model_Account_Tags implements Iterator{
    
    use Application_Model_Trait_Iterable;



    private function __construct() {
        
        $this->rewind();
    }
    
 
    public function setTags(array $tags){
        
        $this->setData($tags);
        return $this;
        
    }
    
    public function getTags(){
        
        return $this->getData();
    }
        
    
    private function setTag(Zend_Db_Table_Row $tag){
        
        $tags = $this->getTags();
        $tags[] = $tag;
        $this->setTags($tags);
        
        return $this;
    }
    
    public static function getAllTags(){

        $tagObj = new Application_Model_DbTable_Tags();
        $thisObj = new Application_Model_Account_Tags();
        

        $tags = $tagObj->fetchAll();
        if ($tags){
            foreach ($tags AS $tag){

                $thisObj->setTag($tag);

            }
        }
         
        return $thisObj;
    }
    
    public static function getTagsByNames($tagNames = null){
        
        $tagsObj = new Application_Model_DbTable_Tags();
        $thisObj = new Application_Model_Account_Tags();
        
        $tags = $tagsObj->fetchTags($tagNames);
        
        if ($tags){
            foreach ($tags AS $tag){
                $thisObj->setTag($tag);
            }
        }
            
        return $thisObj;
        
    }

    public static function getTagsByIds($tagIds = null){
        
        $tagsObj = new Application_Model_DbTable_Tags();
        $thisObj = new Application_Model_Account_Tags();
        
        $tags = $tagsObj->fetchTagsById($tagIds);
        
        if ($tags){
            foreach ($tags AS $tag){
                $thisObj->setTag($tag);
            }
        }
            
        return $thisObj;
        
    }
    
    public static function getTagsByTransactionId($transactionId){
        
        $tagTaxObj = new Application_Model_DbTable_TagTaxonomy();
        $tagObj = new Application_Model_DbTable_Tags();
        $thisObj = new Application_Model_Account_Tags();
        
        $taxonomyIds = $tagTaxObj->fetchTagIdsByTransactionId($transactionId);
        
        if (count($taxonomyIds)>0){

            $tags = $tagObj->fetchTagsById($taxonomyIds);
            if ($tags){
                foreach ($tags AS $tag){
                    
                    $thisObj->setTag($tag);
                    
                }
            }
            
        }
        
        return $thisObj;
    }
 
    
    public static function setTagsByTransactionId($transactionId, Application_Model_Account_Tags $tags){
        
        $tagTaxObj = new Application_Model_DbTable_TagTaxonomy();
        
        // clear existing tags
        $tagTaxObj->delete(array('transaction_id = ?'=>$transactionId));
        
        if (!count($tags)>0){
            return;
        }
        
        foreach ($tags AS $tag){
            $tagTaxObj->insert(array('transaction_id'=>$transactionId,'tag_id'=>$tag->tag_id));
        }
        
    }
    
    
    
}

?>
