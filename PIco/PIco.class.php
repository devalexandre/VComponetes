<?php
/**
 * PIco Widget
 *
 * @version    1.0
 * @version adianti framework 1.0.3
 * @package    widget_web
 * @subpackage PForm
 * @author     Alexandre E. Souza
 */
 
class PIco 
{
 
 
    /**
     * Class Constructor
     * @param  $value text label
     */
    public function __construct($type = 'plus')
    {

          TPage::include_css('app/lib/PComponetes/util/glyphicons.min.css');
        
      
        
               
        // create a new element
        $this->tag = new TElement('i');
        $this->tag->{'class'} ="glyphicon glyphicon-$type";
        
     
     
     
    }
    
    
    /**
     * Shows the widget at the screen
     */
    public function show()
    {
          
        
        // show the tag
        $this->tag->show();
    }
}
?>