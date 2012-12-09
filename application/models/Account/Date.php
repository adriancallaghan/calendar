<?php

class Application_Model_Account_Date
{

    use Application_Model_Trait_Readonly;
    
    
    protected $_balance;
    protected $_date;
    protected $_id;
    protected $_transactions;
    
    
    private function __construct(Application_Model_Calendar_Date $date) {
        
        // primary key of the object
        $this->date = $date;
        
        // initialise the object by making a call to set transactions, this bubbles up through date to database_id, 
        // building the object, if each value is not set
        $this->setTransactions();

        /*
         * Object is automatically Cached afterward, because this object has a private constructor with only one entry point
         */
    }


    private function setDate(Application_Model_Calendar_Date $date){
        
        /*
         * Primary key of the object
         */
        $this->_date = $date;
        return $this;
    }
    
    public function getDate(){
        
        if (!isset($this->_date)){
            throw new Exception('Date not set');
        }
        return $this->_date;
    }
    
    
    
    private function setId(){
        
        /*
         * ID is obtained from the objects primary key, the Key
         * 
         * if ID cannot be retrieved from the databse then the date has not been initialised yet
         * 
         * This method will initialise the object prior to obtaining the ID
         * 
         */

         $datesObj = new Application_Model_DbTable_Dates();
         
         
         // if this date has been initialised set the id and return knowing the object has been initialised 
         if ($date = $datesObj->fetchRow(array('date_key = ?'=>$this->date->systemKey))){
             $this->_id = $date->date_id;
             return $this;
         }
         
         

            // mark as initialised, and set the id, ready to be used for the initalisation process
           $this->_id = $datesObj->insert(array('date_key'=>$this->date->systemKey));



            // create any reoccuring transactions for this date
           
           $defaultTaxObj = new Application_Model_DbTable_DefaultTaxonomy();
           $default_transaction_ids = $defaultTaxObj->getIds($this->date); // pass in the date obj

           // if there is anything worth processing?
           if ($default_transaction_ids){

               $defaultTransactions = Application_Model_Account_Transactions::fetchByTransactionIds($default_transaction_ids);

               foreach ($defaultTransactions AS $transaction){
                   Application_Model_Account_Transactions::newTransaction($transaction, $this->date);
               }
               
           } 


        
        return $this;
    }
    
    public function getId(){
        
        if (!isset($this->_id)){
            $this->setId();
        }
        return $this->_id;
    }

    
    private function setBalance(){
        
        $this->_balance = 0;
        
        if (count($this->transactions)>0){
            foreach ($this->transactions AS $transaction){
                $this->_balance += $transaction->amount;
            }
        }

        return $this;
    }
    
    public function getBalance(){
        if (!isset($this->_balance)){
            $this->setBalance();
        }
        return $this->_balance;
    }
    

    
    private function setTransactions(){
        
         /*
         * if transactions are not set, set them, this will call get database key (id), which will check if the object is initialised
         */
        $this->_transactions = Application_Model_Account_Transactions::fetchByDateIds($this->id);
        
        return $this;
    }
    
    public function getTransactions(){
        
        /*
         * if transactions are not set, set them, this will call get database key (id), which will check if the object is initialised
         */
        if (!isset($this->_transactions)){
            $this->setTransactions();
        }
        
        return $this->_transactions;
        
    }
    
    public function cache(){

        apc_store($this->date->systemKey, $this);
        return $this;
    }
    
    public function uncache(){
        apc_delete($this->date->systemKey);
        return $this;
    }
        
    public static function get(Application_Model_Calendar_Date $date, $cache = true){



        if ($cache && apc_exists($date->systemKey)){
            
            $dateObj = apc_fetch($date->systemKey);
            
        } else {

            $dateObj = new Application_Model_Account_Date($date);
            
            if ($cache){
                $dateObj->cache();
            }
            
        }
        
        
        
        
        return $dateObj;

    }
       

}

