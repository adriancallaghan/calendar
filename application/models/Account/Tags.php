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
        
    
    
    public static function fetchAll(array $where = null,$count = 50, $offset = 0){
        
        
        $tagsInstance = new self; 

        
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $select = $db->select()
             ->from(array('tags' => 'tags'),array()) 
             ->join(array('categories' => 'categories'),'tags.tag_id = categories.category_id',array('category_name')) 
             ->order(array('tag_id DESC'))
             ->limit($count, $offset);
        
        if ($where!==null){
            foreach($where AS $clause=>$parameter){
                $select->where($clause,$parameter);
            }
        }
        

        $rowSet = $db->fetchAll($select);
        $tagsInstance->setTags($rowSet);

        return $tagsInstance;        
        
    }
    
    public static function getTagsByNames($tagNames = null){
        
        return self::fetchAll(array('tag_name IN ?'=>$tagNames));
        
    }

    public static function getTagsByIds($tagIds = null){
        
        return self::fetchAll(array('tag_id IN ?'=>$tagIds));
        
    }
    
    public static function getTagsByTransactionId($transactionId){

       /*
        * SELECT * FROM tag_taxonomy 
            INNER JOIN `tags` ON tag_taxonomy.tag_id = tags.tag_id 
            INNER JOIN `categories` ON tags.tag_id = categories.category_id
            WHERE transaction_id=5;
        */
        
        $tagsInstance = new self; 

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $select = $db->select()
             ->from(array('tag_taxonomy' => 'tag_taxonomy')) 
             ->joinLeft(array('tags' => 'tags'),'tag_taxonomy.tag_id = tags.tag_id') 
             ->joinLeft(array('categories' => 'categories'),'tags.tag_id = categories.category_id') 
             ->where('tag_taxonomy.transaction_id = ?',$transactionId)
             ->order(array('tags.tag_id DESC'));
        
        
        $rowSet = $db->fetchAll($select);

        $tagsInstance->setTags($rowSet);
        
        return $tagsInstance;
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
