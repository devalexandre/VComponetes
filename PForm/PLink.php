<?php




class PLink extends  TField implements IWidget{
	

   protected  $value;
    private $type = 'label label-default';
    private $link;
    /**
     * Class Constructor
     * @param  $value text label
     */
    public function __construct($value,$type = 'default')
    {
    
    TPage::include_css('app/lib/pwd/util/css/bootstrap.css');
        
        // set the label's content
        $this->setValue($value);
        $this->setType($type);
        
               
        // create a new element
        $this->tag = new TElement('a');
        $this->tag->{'class'} = $this->type ;
       
        
        $this->tag-> onmouseover = "style.cursor='default'";
        
     
     
    }
    
    /**
     * Define the field's name
     * @param $name   A string containing the field's name
     */
    public function setLink($link)
    {
    	$this->link = $link;
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
     $this->type = 'label label-'.$type;
    break;
    
    case 'success':
     $this->type = 'label label-'.$type;
    break;
    
    case 'info':
     $this->type = 'label label-'.$type;
    break;
    
    case 'warning':
     $this->type = 'label label-'.$type;
    break;
    
    case 'danger':
     $this->type = 'label label-'.$type;
    break;
    
      
    case 'Link':
     $this->type = 'label label-'.$type;
    break;
    
    default:
     $this->type = 'label label-default';
    
    
   
       }
    
    }
    
    
    
    /**
     * Shows the widget at the screen
     */
    public function show()
    {
       
        
   
     
            // add content to the tag
            $this->tag->add($this->getValue());
            $this->tag->href = $this->link;
        
        // show the tag
        $this->tag->show();
    }
}