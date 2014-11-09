<?php
/**
 * PLabel Widget
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @subpackage PForm
 * @author     Alexandre E. Souza
 */
 
class PLabel implements IWidget
{
 
    private $value;
    private $type = 'glyphicon glyphicon-default';
    private $ico;
    /**
     * Class Constructor
     * @param  $value text label
     */
    public function __construct($value,$type = 'default')
    {

          TPage::include_css('app/lib/PComponetes/util/label.min.css');
        
        // set the label's content
        $this->setValue($value);
        $this->setType($type);
        
               
        // create a new element
        $this->tag = new TElement('label');
        $this->tag->{'class'} = $this->type ;
        
        $this->tag->onmouseover = "style.cursor='default'";
        
     
     
    }
    
    public function setIco(PIco $ico){
    
    $this->ico = $ico;
    }
    
    public function getIco(){
    return $this->ico;
    }
    
       /**
     * Define the field's name
     * @param $name   A string containing the field's name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the field's name
     */
    public function getName()
    {
        return $this->name;
    }
    
    
    public function setValue($v){
    
    $this->value = $v;
    }

    public function getValue()
    {
        return $this->value;
    }


    /**
     * Define the font size
     * @param $size Font size in pixels
     */
    public function setFontSize($size)
    {
        $this->fontSize = $size;
    }
    
    
    /**
     * Add an object inside the label
     * @param $obj An Object
     */
    function add($obj)
    {
        $this->tag->add($obj);
    }
    
     /** Define type of Button
    *primary,success,info,warning,danger,Link
    *@param $type Buttons's type
    */
    
    public function setType($type){
    
    switch($type){
    
    case 'primary':
     $this->type = 'plabel plabel-'.$type;
    break;
    
    case 'success':
     $this->type = 'plabel plabel-'.$type;
    break;
    
    case 'info':
     $this->type = 'plabel plabel-'.$type;
    break;
    
    case 'warning':
     $this->type = 'plabel plabel-'.$type;
    break;
    
    case 'danger':
     $this->type = 'plabel plabel-'.$type;
    break;
    
      
    case 'Link':
     $this->type = 'plabel plabel-'.$type;
    break;
    
    default:
     $this->type = 'plabel plabel-default';
    
    
   
       }
    
    }
    
    
    
    /**
     * Shows the widget at the screen
     */
    public function show()
    {
    
    if($this->getIco()){
        $this->tag->add($this->getIco());
    }
           // add content to the tag
            $this->tag->add($this->value);
        
        
        // show the tag
        $this->tag->show();
    }
}
?>