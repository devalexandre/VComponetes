<?php
/**
 * WelcomeView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006-2012 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class WelcomeView extends TPage
{
    private $html;
    
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        $this->form = new TQuickForm;
        $this->form->class = 'tform';
        $this->form->setFormTitle('Quick Form');

        $select = new HSelect2('select2'); 
        $select->addItems(['Alexandre','Rodrigo']);
        $select->setSelected(['Alexandre']);
     
      $this->form->addQuickField('Description', $select, 380);
      $this->form->addQuickAction('Send', new TAction(array($this, 'onSend')), 'fa:check-circle-o green');
        
        // add the template to the page
        parent::add($this->form);
    }

    public function onSend($param)
    {
        $data = $this->form->getData(); // optional parameter: active record class

        
        // put the data back to the form
        $this->form->setData($data);

        var_dump($data);
    }
}
?>
