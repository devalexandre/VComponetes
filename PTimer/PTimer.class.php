

<?php
/**
 * PTimer Widget
 *
 * @version    1.0
 * @version adianti framework 1.0.3
 * @package    widget_web
 * @subpackage PTimer
 * @author     Alexandre E. Souza
 */
class PTimer  extends TElement{

private $obj;
private $url;

public function __construct(){
parent::__construct('div');

$this->id = 'timer'.uniqid();
$this->{'style'} = "width:400px;heigth:400px;background-color:#000000;";
}


public function putTimer($class){

$this->obj = $class;

}

public function show(){


parent::show();
}
 
       }
       ?>
       
       
      