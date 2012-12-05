<?Php

/*
 * Responsible for a collection of dates, similiar to Zend_table_row has individual rows
 * 
 */

class Application_Model_Calendar_Dates implements Iterator {

    
    use Application_Model_Trait_Readonly;
    use Application_Model_Trait_Iterable;
        
    
    /*
     * class type
     */
    private function __construct(array $options = null)
    {     
        $this->rewind(); // reset the pointer
        
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }


    private function setDates(array $dates = null){
        
        $this->setData($dates);
        return $this;
    }
    
    public function getDates(){
        
        return $this->getData();
        
    }
        
    
    
   
    
    /*
     * Fetches dates and sets them within the instance, defaults to todays date
     */
    public static function query($startDate = null, $endDate = null){
        
        
        // normalise the query, by defaulting
        if (!$startDate instanceof Application_Model_Calendar_Date){
            $startDate = self::Date();
        }

        if (!$endDate instanceof Application_Model_Calendar_Date){
            $endDate = $startDate; // encase just startdate was declared
        }
        
        if ($startDate->unix > $endDate->unix){
            return $this;
        }
        
        // init
        $dates = array();
        $startPoint = $startDate->unix;
        $endPoint = $endDate->unix; 
        $currentPoint = $startPoint; // reset
        
        // loop
        while ($currentPoint <= $endPoint){
            
            //$dates[] = self::Date(array('unix'=>$currentPoint,'builders'=>$this->builders)); // store
            $date = self::Date(); // new date
            $date->unix = $currentPoint;
            
                     
            $dates[] = $date; // store
            
            $currentPoint = self::generateUnixOffset($currentPoint,1); // advance a day
            
        }        
               
        return new Application_Model_Calendar_Dates(array('dates'=>$dates));
    }
                    
    /*
     * Datatypes that can be fetched statically
     */
    public function __toString() {
        return 'Dates collection ('.count($this->dates).')';
    }
       
    
    public static function Date(array $options = null){
        
        return new Application_Model_Calendar_Date($options);
        
    }
    
    public static function getCalendarMonthStartDate(Application_Model_Calendar_Date $date = null){
        
        if ($date===null){
            $date = self::Date();
        }
         
        $date = self::getCalendarMonthEndDate($date); // ensures that we can handle negative months

        $lastFridayOfLastMonth = strtotime("last Friday",mktime( 0, 0, 0, $date->monthNumber, 1, $date->yearNumber));

        return self::Date(array('unix'=>$lastFridayOfLastMonth));

    }
    public static function getCalendarMonthEndDate(Application_Model_Calendar_Date $date = null){
        
        if ($date===null){
            $date = self::Date();
        }
                
        $lastThursday = strtotime("last Thursday",mktime( 0, 0, 0, $date->monthNumber+1, 1, $date->yearNumber));
        
        if ($lastThursday < $date->unix){
            $lastThursday = strtotime("last Thursday",mktime( 0, 0, 0, $date->monthNumber+2, 1, $date->yearNumber));
        }
        
        return self::Date(array('unix'=>$lastThursday));
    }
    

    public static function generateUnix($day=null, $month=null, $year=null){
        
        // only place the date is computed, i.e set!
        $day = $day==null ? date('j') : $day;
        $month = $month==null ? date('m') : $month;
        $year = $year==null ? date('Y') : $year;
        
        $unix = mktime(0,0,0,$month,$day,$year);
        return $unix;
    }

    public static function generateUnixFromSystemKey($systemKey){
        
        if (strlen($systemKey)<8){
            return null;
        }

        $dateArray = str_split($systemKey,2); // break into 4, 2 digit chunks ie 19.77.08.23
        
        $day = $dateArray[3];
        $month = $dateArray[2];
        $year = $dateArray[0].$dateArray[1];
        
        // make a request to get the unix from these vars
        return self::generateUnix($day, $month, $year);
    }
    /*
     * Returns a unix date of the future past, or current
     */
    public static function generateUnixOffset($unix=null, $dayOffset = 0) {
        
        if ($unix===null){
            $unix = self::Date()->getUnix();
        }
        
        return $unix + ($dayOffset * (24 * 60 * 60));  
    }
    
            
}