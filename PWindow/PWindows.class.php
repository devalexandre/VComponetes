<?php




class PWindows extends TElement{

function __construct(){

parent::__construct('div');
$this->id = 'windos'.uniqid();
$this->width = '800';
$this->height = '400';


}

public function addContent($contente){

if (ob_get_level() == 0) ob_start();

for ($i = 0; $i <= 10 ; $i++){

       parent::add($contente);
        echo str_pad('',4096)."\n";   

        ob_flush();
        flush();
        sleep(2);
}



ob_end_flush();


}

public function show(){

$script = new TElement('script');
$script->type = 'text/javascript';

$code = "$(function() {
$('#$this->id').dialog({ minWidth: 800,minHeight: 400 } );
});";

$script->add($code);

parent::add($script);
parent::show();
}
}
?>