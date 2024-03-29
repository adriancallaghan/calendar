<?php


class Application_Model_Account_Transaction {
    
    
    use Application_Model_Trait_Readonly;
    
    protected $_id;
    protected $_active;
    protected $_name;
    protected $_amount;
    protected $_tags;
    protected $_categories;


    public function setId($id = null){
        
        $this->_id = $id;
        return $this;
        
    }
    
    public function getId(){
        
        if (!isset($this->_id)){
            $this->setId();
        }
        return $this->_id;
        
    }
    
    public function setName($name = null){
        
        $this->_name = $name;
        return $this;
        
    }
    
    public function getName(){
        
        if (!isset($this->_name)){
            $this->setName();
        }
        return $this->_name;
        
    }
    
     public function setActive($active = null){
        
        $this->_active = $active;
        return $this;
        
    }
    
    public function getActive(){
        
        if (!isset($this->_active)){
            $this->setActive();
        }
        return $this->_active;
        
    }
    
    public function setAmount($amount = null){
        
        $this->_amount = $amount;
        return $this;
        
    }
    
    public function getAmount(){
        
        if (!isset($this->_amount)){
            $this->setAmount();
        }
        return $this->_amount;
        
    }
    
    public function setTags(Application_Model_Account_Tags $tags = null){
        
        $this->_tags = $tags;
        return $this;
        
    }
    
    public function getTags(){
        
        if (!isset($this->_tags)){
            $this->setTags();
        }
        return $this->_tags;
        
    }
    
     public function setCategories(Application_Model_Account_Categorys $categories = null){
        
        $this->_categories = $categories;
        return $this;
        
    }
    
    public function getCategories(){
        
        if (!isset($this->_categories)){
            $this->setCategories();
        }
        return $this->_categories;
        
    }
}

?>
