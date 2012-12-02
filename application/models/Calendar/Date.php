<?Php
class Application_Model_Calendar_Date {


    protected $_unix;
    
    
    public function __construct(array $options = null)
    {
        
        if (is_array($options)) {
            $this->setOptions($options);
            
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (method_exists($this, $method)) {
            $this->$method($value);
            return $this;
        }
                
        throw new Exception('Invalid Date property');
        
    }

    public function __get($name)
    {
        
        $method = 'get' . $name;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        
        throw new Exception('Invalid Date property');
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }  
    
    
    /*
     * 
     * Everything resolves to setUnix
     * 
     */
    public function setUnix($unixTimeStamp = null){
        
        if ($unixTimeStamp===null){
            $unixTimeStamp = mktime();
        }
        
        $this->_unix = $unixTimeStamp;
        return $this->init();
    }
    
    public function getUnix(){

        if (!isset($this->_unix)){
            $this->setUnix();
        }
        return $this->_unix;
    }
    
    public function getSystemKey(){

        return date("Ymd", $this->unix);
    }
    
    
    public function getDayNumber(){
        
        return date("j", $this->unix); 
        
    }
    
    public function getMonthNumber(){
        
        return date("n", $this->unix); 

    }
    
    public function getYearNumber(){
        
        return date("Y", $this->unix); 
        
    }
    
    public function getDayName(){
        return date("l",$this->unix);
    }
    
    public function getMonthName(){
        
        return date("F", $this->unix); 

    }
    
    public function getDayOfWeekNumber(){
        
        return date("N", $this->unix);
    }
    
    public function getWeekDay(){
        
        switch ($this->dayName){
            case 'Saturday' : 
            case 'Sunday' : 
            return false;   
        }
        return true;
    }
    
    public function getTomorrow() {

        return new $this(array('unix'=>$this->unix + (1 * (24 * 60 * 60))));  
    }
    
    public function getYesterday() {
                
        return new $this(array('unix'=>$this->unix + (-1 * (24 * 60 * 60))));
    }
    
    private function init(){
        
        
    }
    
    
    public function toArray(){
        
        return array(
            'dayName'=>$this->dayName,
            'dayNumber'=>$this->dayNumber,
            'monthName'=>$this->monthName,
            'monthNumber'=>$this->monthNumber,
            'systemKey'=>$this->systemKey,
            'unix'=>$this->unix,
            'weekday'=>$this->weekDay,
            'yearNumber'=>$this->yearNumber,
        );        
             
    }
    
    public function __toString() {
        
        return date("l jS \of F Y", $this->unix);
    }
    
    
}