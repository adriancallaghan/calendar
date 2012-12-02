<?php

class Application_Model_Account_Transactions implements Iterator {
   
    protected  $_names;
    protected $_amounts;
    protected $_categories;
    protected $_tags;   
    
    protected $_position;
    protected $_order;
    
    
    
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

        return $this->getTransaction($this->_position); // returns null if not valid
        
    }

    public function key() {

        return $this->_position;
    }

    public function next() {

        ++$this->_position;
    }

    public function valid() {

        return isset($this->_order[$this->_position]);
    }
    
    public function getTransaction($key){
        
        /*
         * Returns a transaction object
         */
        if  (!isset($this->_order[$key])){
            return null;
        }
        
        $transId = $this->_order[$key];
            
        $transactionObj = new Application_Model_Account_Transaction();
        $transactionObj->amount = $this->_amounts[$transId];
        $transactionObj->name = $this->_names[$transId];
        $transactionObj->tags = $this->_tags[$transId];
        $transactionObj->categories = $this->_categories[$transId];

        return $transactionObj;
            
    }
    
    private function addTransaction(Zend_Db_Table_Row $transaction, Application_Model_Account_Categorys $categories, Application_Model_Account_Tags $tags){
        
        $this->_order[] = $transaction->id;
        $this->_amounts[$transaction->id] = (float) $transaction->amount;
        $this->_names[$transaction->id] = (string) $transaction->name;
        $this->_categories[$transaction->id] = $categories;
        $this->_tags[$transaction->id] = $tags;

        return $this;
    }
    
    public static function fetchByDateIds($id){
    
        $datetax = new Application_Model_DbTable_DateTaxonomy();
        $transactions = $datetax->fetchTransactions($id);

        
        if (!$transactions){            
            return null;
        }
        
        
        $ids = array();
        foreach($transactions AS $transaction){
                $ids[] = $transaction->transaction_id;
        }
            
        return self::fetchByTransactionIds($ids);
        
    }
    
    public static function fetchByTransactionIds(array $transactionIdIds, $onlyActive = true){
        
         $thisObj = new Application_Model_Account_Transactions();
        
         if ($transactionIdIds){
            
            $transactionIdObj = new Application_Model_DbTable_Transactions();           

            foreach ($transactionIdIds AS $transactionId){

                $transactionDetails = $transactionIdObj->fetchTransaction($transactionId);
                
                if (!$onlyActive || $transactionDetails->active){
                    $categories = Application_Model_Account_Categorys::getCategoriesByTransactionId($transactionId);
                    $tags = Application_Model_Account_Tags::getTagsByTransactionId($transactionId);
                    $thisObj->addTransaction($transactionDetails, $categories, $tags);
                }
            }
            
            
        }

        return $thisObj;
        
    }
    
    public static function updateTransaction(Application_Model_Account_Transaction $transaction){
        
    }
    
    public function moveTransaction(Application_Model_Account_Transaction $transaction, Application_Model_Calendar_Date $from, Application_Model_Calendar_Date $to){
        
        $dateTaxObj = new Application_Model_DbTable_DateTaxonomy();
        $datesObj = new Application_Model_DbTable_Dates();
        $dateKey = $datesObj->getDbKey($from);
         
        if ($dateKey){
            
            //$dateTaxObj->findId($dateKey, $transactionId);
            //$dateTaxObj->insert(array('transaction_id'=>$transactionId,'date_id'=>$dateDb->date_id));
        }
        
    }
    
    public static function newTransaction(Application_Model_Account_Transaction $transaction, Application_Model_Calendar_Date $date){
        
        
        $datesObj = new Application_Model_DbTable_Dates();
        
        $dateKey = $datesObj->getDbKey($date);
         
        if (!$dateKey){
            // no such date
            return false;
        }
        
        $transactionObj = new Application_Model_DbTable_Transactions();
        $dateTaxObj = new Application_Model_DbTable_DateTaxonomy();
           
        /*
         * Saves a transaction to a date
         */
                           
        // duplicate the transaction
        $transactionId = $transactionObj->insert(
                array(
                    'name'=>$transaction->name,
                    'amount'=>$transaction->amount,
                    'active'=>'1'
                    )
                );
        
        // add it to the date taxonomy
        $dateTaxObj->insert(array('transaction_id'=>$transactionId,'date_id'=>$dateKey));
        
        /*
         * Add tags and categories etc
         */
        if ($transaction->tags){
            Application_Model_Account_Tags::setTagsByTransactionId($transactionId, $transaction->tags);
        }
        if ($transaction->categories){
            Application_Model_Account_Categorys::setCategoriesByTransactionId($transactionId, $transaction->categories);
        }
        
        return true;
    }
    
}

?>
