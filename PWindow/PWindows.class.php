<?php




class PWindows extends TElement{

private $modal;
private $title;

function __construct(){

parent::__construct('div');
$this->id = 'windos'.uniqid();
$this->width = null;
$this->height = null;
$this->title = null;

}

public function setTitle($title){
$this->title = ",title: '$title'";
}

public function setSize($width,$height){

$this->width = $width;
$this->height = $height;

}

public function addContent($contente){


       parent::add($contente);
  
}

public  function setModal($modal = false){

$this->modal = ",modal: $modal";

}

public function show(){

if(($this->height == null) || ($this->width == null)){

throw new Exception('size não especificado');
}

if($this->height == null){

throw new Exception('title não especificado');
}

$script = new TElement('script');
$script->type = 'text/javascript';

$code = "$(function() {
$('#$this->id').dialog({ minWidth: $this->width,minHeight: $this->height $this->modal $this->title} );
});";

$script->add($code);

parent::add($script);
parent::show();
}
}
?>