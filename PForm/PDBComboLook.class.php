<?php

/**
 * PDBComboLook Widget
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @subpackage PForm
 * @author     Alexandre E. Souza
 */

class PDBComboLook extends TDBFCombo{


   protected $changeaction; 
    protected $function;
    protected $banco;
    
    /**
     * Class Constructor
     * @param  $name     widget's name
     * @param  $database database name
     * @param  $model    model class name
     * @param  $key      table field to be used as key in the combo
     * @param  $value    table field to be listed in the combo
     * @param  $ordercolumn column to order the fields (optional)
     * @param  array $filter   TFilter (optional) By Alexandre
     * @param array $expresione TExpression (opcional) by Alexandre
     
     */

public function __construct($name, $database, $model,
            $key, $value, $ordercolumn = NULL,$filter = NULL,
            $expression = NULL){

parent::__construct($name, $database, $model,
            $key, $value, $ordercolumn = NULL,$filter = NULL,
            $expression = NULL);
    
    TPage::include_css('app/lib/pwd/util/css/bootstrap.css');

    $this->banco = $database;
    
 }
 
   
    
     /**
     * Define the action to be executed when the user changes the combo
     * @param $action TAction object
     */
    public function setChangeAction(TAction $action)
    {
        $this->changeaction = $action;
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
    


public function addPopulationTarget(TCombo $alvo,$model,$frm,$key_busca,$value,$key_valor,$ordercolumn= null){

if($this->changeaction){
// carrega objetos do banco de dados
        TTransaction::open($this->banco);
        // instancia um repositório de Estado
        $repository = new TRepository($model);
        $criteria = new TCriteria;
        $criteria->setProperty('order', isset($ordercolumn) ? $ordercolumn : $key_busca);
        $criteria->add(new TFilter($key_busca, '=',$key_valor));
        
        
     
        // carrega todos objetos
        $collection = $repository->{$model};
        
     
            $items = array();
            
            foreach ($collection as $object)
            {
                $items[$object->$key] = $object->$value;
                
            }
       

           
        TCombo::reload($frm,$alvo->getName(),$items);
        TTransaction::close();
}else{

throw new Exception('you need delcare changeaction first');
}


           
                      
                     
}



public function show(){
if ($this->changeaction)
        {
        
        
            if (empty($this->formName))
            {
                throw new Exception(TAdiantiCoreTranslator::translate('You must pass the ^1 (^2) as a parameter to ^3', __CLASS__, $this->label, 'TForm::setFields()') );
            }
            
            // get the action as URL
            $url = $this->changeaction->serialize(FALSE);
          
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
                       
                       
                       }
                       
                       
              
              
        // define the tag properties
        $this->tag-> name  = $this->name;    // tag name
        $this->tag-> style = "width:{$this->size}px";  // size in pixels
        $this->tag->onChange = $action;
        
        // creates an empty <option> tag
        $option = new TElement('option');
        $option->add('');
        $option-> value = '';   // tag value
        // add the option tag to the combo
        $this->tag->add($option);
        
        if ($this->items)
        {
            // iterate the combobox items
            foreach ($this->items as $chave => $item)
            {
                if (substr($chave, 0, 3) == '>>>')
                {
                    $optgroup = new TElement('optgroup');
                    $optgroup-> label = $item;
                    // add the option to the combo
                    $this->tag->add($optgroup);
                }
                else
                {
                    // creates an <option> tag
                    $option = new TElement('option');
                    $option-> value = $chave;  // define the index
                    $option->add($item);      // add the item label
                    
                    // verify if this option is selected
                    if (($chave == $this->value) AND ($this->value !== NULL))
                    {
                        // mark as selected
                        $option-> selected = 1;
                    }
                    
                    if (isset($optgroup))
                    {
                        $optgroup->add($option);
                    }
                    else
                    {
                        $this->tag->add($option);
                    }                    
                }
            }
        }
        
       
        // shows the combobox
        $this->tag->show();
                       
                      
                  }
              

}

?>