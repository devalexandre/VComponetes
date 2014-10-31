<?php

class PImage 
{
    private $img; // image path
    
    /**
     * Class Constructor
     * @param $source Image path
     */
    public function __construct($source,$local = true)
    {
       $this->img = new TElement('img');
       if($local){
        // assign the image path
        $this->img->src = "http://".$_SERVER['SERVER_NAME'].'/'.$source;
        }else{
         $this->img->src = $source;
        }
        $this->img->border = 0;
    }
    
    public function renderize(){
    
    
    return $this->img;
}
}

?>