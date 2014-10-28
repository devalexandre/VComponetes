<?php


class PVideo extends TElement
{
    private $source; // image path
    
    
    
    /**
     * Class Constructor
     * @param $source video path
     * @see format .flv
     */
    public function __construct($source,$youtube = true)
    {
        parent::__construct('embed');
        // assign the image path
        
        
        
        if($youtube == true){
        
        $this-> src = "http://www.youtube.com/v/$source";
        
        }else{
        $this-> src = $source;
        }
        
        $this->type = "application/x-shockwave-flash";
      
    }
    
    
    public function setSize($width = 400, $height = 345){
    
    
    $this->width = $width;
    $this->height = $height;

    }
    
    
    public function setClass($class){
    
    $this->class= $class;
    }
}
?>