<?php


class Application_Model_Account_Tags implements Iterator{
    
    protected $_position;
    protected $_tags;


    private function __construct() {
        
        $this->rewind();
    }
    
    
     /*
     * Iterator related
     */
    
    public function rewind() {

        $this->_position = 0;
    }

    public function current() {

        // main and only accessor, calls build
        if ($this->valid()){

            return $this->_tags[$this->_position];
        }
    }

    public function key() {

        return $this->_position;
    }

    public function next() {

        ++$this->_position;
    }

    public function valid() {

        return isset($this->_tags[$this->_position]);
    }
    
    
    public function setTags(array $tags){
        
        $this->_tags = $tags;
        return $this;
        
    }
    
    public function getTags(){
        
        return $this->_tags;
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
        
        if (!count($tags)>0){
            return;
        }
        
        $tagTaxObj = new Application_Model_DbTable_TagTaxonomy();
        
        foreach ($tags AS $tag){
            $tagTaxObj->insert(array('transaction_id'=>$transactionId,'tag_id'=>$tag->tag_id));
        }
        
    }
    
    
}

?>
