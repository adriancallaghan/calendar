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
        
        $this->addElement('text', 'id', array(
            'hidden'      => true
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
                
        $this->addElement('checkbox', 'active', array(
            'label'      => 'Active: '
        ));
        
        /*$this->addElement('hash', 'csrf', array(
            'ignore'     => true
        ));*/
        

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
    
    public function setTagsActive(Application_Model_Account_Tags $tagsObj){
        
        $tags = array();
        
        if ($tagsObj){
            foreach($tagsObj AS $tagObj){
                $tags[] = $tagObj->tag_id;
            }
        }
        
        $this->getElement('tags')->setValue($tags);
        return $this;
    }
    
    public function setCategoriesActive(Application_Model_Account_Categorys $categoriesObj){
        
        $categories = array();
        
        if ($categoriesObj){
            foreach($categoriesObj AS $categoryObj){
                $categories[] = $categoryObj->category_id;
            }
        } 

        $this->getElement('categories')->setValue($categories);
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
    
    public function getTransaction() {
        
        // data        
        $transactionData = array(
            'name'=>$this->getValue('name'),
            'amount'=>$this->getValue('amount'),
            'active'=>$this->getValue('active'),
            'id'=>$this->getValue('id'),
            'tags'=>Application_Model_Account_Tags::getTagsByIds($this->getValue('tags')),
            'categories'=>  Application_Model_Account_Categorys::getCategoriesByIds($this->getValue('categories'))
            );

        return new Application_Model_Account_Transaction($transactionData);
        
    }
    
    public function populateByTransaction(Application_Model_Account_Transaction $transaction) {
        
        $this->getElement('id')->setValue($transaction->id);
        $this->getElement('name')->setValue($transaction->name);
        $this->getElement('amount')->setValue($transaction->amount);
        $this->getElement('active')->setValue($transaction->active);
        $this->setTagsActive($transaction->tags);
        $this->setCategoriesActive($transaction->categories);       
        
    }
 
}

