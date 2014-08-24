<?php


class PImage extends TElement
{
    private $source; // image path
    
    
    
    /**
     * Class Constructor
     * @param $source Image path
     */
    public function __construct($source)
    {
        parent::__construct('img');
        // assign the image path
        $this-> src = $source;
        $this-> border = 0;
    }
    
    
    public function setSize($width){
    
    
    $this->width = $width;

    }
    
    
    public function  setClass($class){
    
    $this->class= $class;
    }
}
?>