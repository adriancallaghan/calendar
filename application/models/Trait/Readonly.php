<?php

trait Application_Model_Trait_Readonly{
    
    
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
                
        throw new Exception('Invalid '.__CLASS__.' property');
        
    }

    public function __get($name)
    {
        
        $method = 'get' . $name;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        
        throw new Exception('Invalid '.__CLASS__.' property');
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
    
}

?>
