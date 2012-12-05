<?php


class Application_Model_Account_Statement implements Iterator{
    
    
    protected $_position;
    protected $_dates;
    protected $_balance;
    
    
    private function __construct(array $dates){
        
        $this->rewind();
                
        if (count($dates)>0){
            foreach ($dates AS $date){
                $this->addDate($date);
            }
        } 
        
    }
    
    /*
     * Iterator related
     */
    
    public function rewind() {

        $this->_position = 0;
    }

    public function current() {

        if ($this->valid()){
            return $this->_dates[$this->_position]; // returns null if not valid
        }
    }

    public function key() {

        return $this->_position;
    }

    public function next() {

        ++$this->_position;
    }

    public function valid() {

        return isset($this->_dates[$this->_position]);
    }
    
    public function getBalance(){
        
        return $this->_balance;
    }
    
    private function addDate(Application_Model_Account_Date $date){
    
        $this->_dates[] = $date;
        $this->_balance += $date->balance;
        
        return $this;
    }
    
    
    public static function query(Application_Model_Calendar_Dates $dates, $cache = true){
        
        

       $accountDates = array();
        
        foreach ($dates AS $date){

            $accountDates[] =  Application_Model_Account_Date::get($date, $cache);
            
        }
        
        return new Application_Model_Account_Statement($accountDates);
        
    }
    
    
    
}


?>
