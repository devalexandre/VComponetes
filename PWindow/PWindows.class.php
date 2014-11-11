<?php




class PWindows extends TElement{

function __construct(){

parent::__construct('div');
$this->id = 'windos'.uniqid();



}

public function setSize($width,$height){

$this->width = $width;
$this->height = $height;

}

public function addContent($contente){


       parent::add($contente);
     

}

public function show(){

if(($this->height == null) || ($this->width)){

throw new Exception('size não especificado');
}
$script = new TElement('script');
$script->type = 'text/javascript';

$code = "$(function() {
$('#$this->id').dialog({ minWidth: $this->width,minHeight: $this->height } );
});";

$script->add($code);

parent::add($script);
parent::show();
}
}
?>