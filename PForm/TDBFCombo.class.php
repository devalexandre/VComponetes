 <?php
/**
 * Database Filter ComboBox Widget
 *
 * @version    1.0
 * @package    widget_web
 * @subpackage form
 * @author     Guilherme Faht
 * @copyright  Copyright (c) 2006-2013 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 * Alterado por
 * Alexandre E. Souza
 */
 

class TDBFCombo extends TCombo 
{
    protected $items; // array containing the combobox options
    
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
            $key, $value, $ordercolumn = NULL, $filter = NULL,
            $expression = NULL)
    {
    	
    	new TSession();
    	
        // executes the parent class constructor
        parent::__construct($name);
        
        // carrega objetos do banco de dados
        TTransaction::open($database);
        // instancia um repositÃ³rio de Estado
        $repository = new TRepository($model);
        $criteria = new TCriteria;
        $criteria->setProperty('order', isset($ordercolumn) ? $ordercolumn : $key);
        
        if($filter){
        foreach ($filter as $fil){
            if($expression){
                foreach ($expression as $ex){
                     $criteria->add($fil,$ex); 
                }
            }else{
            $criteria->add($fil); 
            }
        }}
        // carrega todos objetos
        $collection = $repository->load($criteria);
        
        // adiciona objetos na combo
        if ($collection)
        {
            $items = array();
            foreach ($collection as $object)
            {
                $items[$object->$key] = $object->$value;
            }
            parent::addItems($items);
        }
        TTransaction::close();
    }
    
    /**
     * Shows the widget
     */
    public function show()
    {
        // define the tag properties
        $this->tag-> name  = $this->name;    // tag name
        $this->tag-> style = "width:{$this->size}px";  // size in pixels
        
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
        
        // verify whether the widget is editable
        if (parent::getEditable())
        {
            if (isset($this->changeaction))
            {
                $string_action = $this->changeaction->serialize(FALSE);
                $this->setProperty('onChange', "serialform=(\$('#{$this->formName}').serialize());
                                              ajaxLookup('$string_action&'+serialform, this)");
            }
        }
        else
        {
            // make the widget read-only
            $this->tag->readonly = "1";
            $this->tag->disabled = "disabled";
            $this->tag->{'class'} = 'tfield_disabled'; // CSS
        }
        // shows the combobox
        $this->tag->show();
    }
    
  
  
}
?> 