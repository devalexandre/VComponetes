

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


class PTimer  extends TElement
{
    private $action;


    private $function;

    private $timer;

    protected $button;


    public function __construct($name,$timer){

        self::setName($name);


        $this->timer = $timer;

        TPage::include_css('app/lib/PComponetes/util/css/bootstrap.css');

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
     * Add a JavaScript function to be executed by the button
     * @param $function A piece of JavaScript code
     * @ignore-autocomplete on
     */
    public function addFunction($function)
    {
        $this->function = $function;
    }

    public function status($status){
        TSession::setValue('status',$status);
    }

    /**
     * Show the widget at the screen
     */
    public function show()
    {
        if (TSession::getValue('status')) {
            if ($this->action) {
                if (empty($this->formName)) {
                    throw new Exception(TAdiantiCoreTranslator::translate('You must pass the ^1 (^2) as a parameter to ^3', __CLASS__, $this->label, 'TForm::setFields()'));
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

                              }


                       return false;";

                $this->button = new TElement('div');
                $this->button->onload = $action;
                $this->button->id = $this->name;
                $this->button->name = $this->name;

            }


            $this->button->show();
        }
    }


}

?>