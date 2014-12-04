<?php

class PPanelGrupe extends TElement{

private $code;

  public function __construct($width = 500,$height = 400){
parent::__construct('div');
$this->id = "PPanelGrupe".uniqid();
$this->style = "
border:1px solid #000;
width :{$width}px;
height :{$height}px;
";
 TPage::include_css('app/lib/PComponetes/util/fieldset.css');
$this->code = array();
}

public function appendFrame(TFrame $frame){

$this->code[] = $frame;

parent::add($frame);
}

public function show(){

$c = "";


foreach($this->code as $frames):


$c .= "$( '#".$frames->id."' ).resizable({
containment: '#$this->id'
});";


endforeach;


$code = "$(function() {
 
".$c."

});";

$script = new TElement('script');
$script->type = 'text/javascript';
$script->add($code);

parent::add($script);

parent::show();
}
}
?>