<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/25/14
 * Time: 10:08 AM
 */

class PMessage extends TElement{



    /**
     * @param String $type
     * @param String $titulo
     * @param String $msg
     */

    function __construct($type,$titulo,$msg){
       parent::__construct('div');

        TPage::include_js('app/lib/PComponetes/util/jquery-ui/jquery-ui.js');
        TPage::include_css('app/lib/PComponetes/util/jquery-ui/jquery-ui.css');
        TPage::include_css('app/lib/PComponetes/util/jquery-ui/jquery-ui.structure.css');
        TPage::include_css('app/lib/PComponetes/util/jquery-ui/jquery-ui.theme.min.css');

        $this->id = uniqid();
        $this->title = $titulo;


$panel = new TElement('div');
$body = new TElement('div');

        $panel->{'class'}= "panel panel-default col-sm-12 col-xs-12";
        $body->{'class'} = 'panel-body';

        $panel->add($body);

        $body->add($msg);


        $box = new TVBox();



        $box->add($this->setType($type));
        $box->add($panel);



parent::add($box);

    }



    public function setType($type){

        switch($type){



            case 'success':
                return new PLabel('success',$type);
                break;

            case 'info':

                return new PLabel('info',$type);
                break;

            case 'warning':

                return new PLabel('warning',$type);
                break;

            case 'danger':

                return new PLabel('danger',$type);
                break;
                 default:
                return new PLabel('danger',$type);



        }

    }


/**
 * @param \tag $name
 */
public function setName($name)
{
    $this->name = $name;
}/**
 * @return \tag
 */
public function getName()
{
    return $this->name;
}/**
 * @param mixed $properties
 */
public function setProperties($properties)
{
    $this->properties = $properties;
}/**
 * @return mixed
 */
public function getProperties()
{
    return $this->properties;
}


public function show(){


    $script = new TElement('script');

    $script->{'type'} = 'text/javascript';

    $script->add('

     $().ready(function() {

$( "#'.$this->id.'" ).dialog({
modal: true,
buttons: {
Ok: function() {
$( this ).dialog( "close" );
}
}

});

});
    ');

    $script->show();
    parent::show();
}
}

