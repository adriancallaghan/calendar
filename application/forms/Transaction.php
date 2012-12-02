<?php

class Application_Form_Transaction extends Zend_Form
{

     
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        
        $this->addElement('text', 'name', array(
            'label'      => 'Name:',
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        
        $this->addElement('text', 'amount', array(
            'label'      => 'Amount:',
            'required'   => true,
            'validators' => array('Float'),
            'filters'    => array('StringTrim')
        ));
        
        $this->addElement('submit', 'save', array(
            'ignore'     => true
        ));

        $this->addElement('multiselect','tags', array(
            'label'      => 'Tags: '
        ));
        
        $this->addElement('multiselect','categories', array(
            'label'      => 'Categories: '
        ));
                
        $this->addElement('text', 'date', array(
            'required'   => true,
            'hidden'     => true,
            'filters'    => array('StringTrim')
        ));
        
        /*$this->addElement('hash', 'csrf', array(
            'ignore'     => true
        ));*/
        
        $this->setAction('/ajax/savetransaction');
    }
    
    
    public function setTags(Application_Model_Account_Tags $tagsObj){
        
        $tags = array();
        
        if ($tagsObj){
            foreach($tagsObj AS $tagObj){
                $tags[$tagObj->tag_id] = $tagObj->tag_name;
            }
        }
        
        $this->getElement('tags')->setMultiOptions($tags);
        return $this;
    }
    
    public function setCategories(Application_Model_Account_Categorys $categoriesObj){
        
        $categories = array();
        
        if ($categoriesObj){
            foreach($categoriesObj AS $categoryObj){
                $categories[$categoryObj->category_id] = $categoryObj->category_name;
            }
        }
        
        $this->getElement('categories')->setMultiOptions($categories);
        return $this;
        
      }
    
    public function setDate(Application_Model_Calendar_Date $date){
        $this->getElement('date')->setValue($date->unix);
        return $this;
    }
    
    public function getDate(){
        
        
        return Application_Model_Calendar_Dates::Date(array('unix'=>$this->getElement('date')->getValue()));
        
    }
    
    public function getTransaction() {
        
        // data        
        $transactionData = array(
            'name'=>$this->getValue('name'),
            'amount'=>$this->getValue('amount'),
            'tags'=>Application_Model_Account_Tags::getTagsByIds($this->getValue('tags')),
            'categories'=>  Application_Model_Account_Categorys::getCategoriesByIds($this->getValue('categories'))
            );

        return new Application_Model_Account_Transaction($transactionData);
        
    }
    
 
}

