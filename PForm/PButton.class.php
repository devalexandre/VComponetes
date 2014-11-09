

<?php
/**
 * PButton Widget
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @subpackage PForm
 * @author     Alexandre E. Souza
 */
 
 
class PButton  extends TField implements IWidget
{
    private $action;
    private $label;
    private $image;
    private $function;
    private $type;
    private $ico;
   
    protected $button;

    
    public function __construct($name,$type = 'default' ){

      self::setName($name);
      $this->setType($type);

        TPage::include_css('app/lib/PComponetes/util/btn.min.css');
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
    
    
     /**
     * Define the name of the form to wich the button is attached
     * @param $name    A string containing the name of the form
     * @ignore-autocomplete on
     */
    public function setFormName($name)
    {
        $this->formName = $name;
    }
    
     public function setIco(PIco $ico){
     $this->ico = $ico;
     
     }
      private  function getIco(){
    return  $this->ico ;
     
     }
     
    /** Define type of Button
    *primary,success,info,warning,danger,Link
    *@param $type Buttons's type
    */
    
    public function setType($type){
    
    switch($type){
    
    case 'primary':
     $this->type = 'pbtn pbtn-'.$type;
    break;
    
    case 'success':
     $this->type = 'pbtn pbtn-'.$type;
    break;
    
    case 'info':
     $this->type = 'pbtn pbtn-'.$type;
    break;
    
    case 'warning':
     $this->type = 'pbtn pbtn-'.$type;
    break;
    
    case 'danger':
     $this->type = 'pbtn pbtn-'.$type;
    break;
    
      
    case 'Link':
     $this->type = 'pbtn pbtn-'.$type;
    break;
    
    default:
     $this->type = 'pbtn pbtn-default';
    
    
   
       }
    
    }
    

    
    /**
     * Define the action of the button
     * @param  $action TAction object
     * @param  $label  Button's label
     */
    public function setAction(TAction $action, $label)
    {
        $this->action = $action;
        $this->label  = $label;
    }
    
    /**
     * Define the icon of the button
     * @param  $image  image path
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    
    /**
     * Define the label of the button
     * @param  $label button label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Add a JavaScript function to be executed by the button
     * @param $function A piece of JavaScript code
     * @ignore-autocomplete on
     */
    public function addFunction($function)
    {
        $this->function = $function;
    }
    
    /**
     * Show the widget at the screen
     */
    public function show()
    {
        if ($this->action)
        {
            if (empty($this->formName))
            {
                throw new Exception(TAdiantiCoreTranslator::translate('You must pass the ^1 (^2) as a parameter to ^3', __CLASS__, $this->label, 'TForm::setFields()') );
            }
            
            // get the action as URL
            $url = $this->action->serialize(FALSE);
            
            $wait_message = TAdiantiCoreTranslator::translate('Loading');
            // define the button's action (ajax post)
            $action = "
                      $.blockUI({ 
                            message: '<h1>{$wait_message}</h1>',
                            css: { 
                                border: 'none', 
                                padding: '15px', 
                                backgroundColor: '#000', 
                                'border-radius': '5px 5px 5px 5px',
                                opacity: .5, 
                                color: '#fff' 
                            }
                        });
                       {$this->function};

                       $.post('engine.php?{$url}',
                              \$('#{$this->formName}').serialize(),
                              function(result)
                              {
                                  __adianti_load_html(result);
                                  $.unblockUI();
                              });




                       return false;";
                        
            $this->button = new TElement('button');
            $this->button->{'class'} = $this->type;
            $this->button-> onclick   = $action;
            $this->button-> id   = $this->name;
            $this->button-> name = $this->name;
            $action = '';
        }
        else
        {
            $action = $this->function;
            // creates the button using a div
            $this->button = new TElement('div');
            $this->button-> id   = $this->name;
            $this->button-> name = $this->name;
            $this->button->{'class'} = $this->type;
            $this->button-> onclick  = $action;
        }
        
        $span = new TElement('span');
        if ($this->image)
        {
            if (file_exists('lib/adianti/images/'.$this->image))
            {
                $image = new TImage('lib/adianti/images/'.$this->image);
            }
            else
            {
                $image = new TImage('app/images/'.$this->image);
            }
            $image->{'style'} = 'padding-right:4px';
            $span->add($image);
        }
        
        if($this->getIco()){
        
           $this->button->add($this->getIco());
        }
        
        $span->add($this->label);
        $this->button->add($span);
        $this->button->show();
    }
    
}

?>