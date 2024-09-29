<?php namespace HammadIdrees\HelloWorld\Model; 

class TigrenAttribute implements \HammadIdrees\HelloWorld\Api\Data\TigrensAttributeInterface 

{ 
    
    /** * {@inheritdoc} */ 
    
    public function getValue() 
    
    { 
        return $this->getData(self::VALUE); 
    } 
    
    /** * {@inheritdoc} */ 
    
    public function setValue($value) 
    
    { 
        return $this->setData(self::VALUE, $value); 
    
    } 
}