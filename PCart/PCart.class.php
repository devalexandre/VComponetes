<?php

 class PCart{
 
private $cart;
  //Coloca o novo Carrinho de Compras na sessão
  function __construct(){
  
  $this->cart = array();
 

  }


  public function addItem(PProduto $produto){

  
$this->cart[$produto->getId()] = $produto;

$this->atualiza();

}

public function removeItem($id){

unset( $this->cart[$id]);
$this->atualiza();
}

  
 public function debug(){
 
 var_dump($this->cart);
 }
 
 public static function getItens(){
  $cart = TSession::getValue('cart');
  
 return $cart;
 }
 
 
 public function clean(){
 
TSession::setValue('cart',array());
 }
 
 public function getIten($id){
 
 $cart = TSession::getValue('cart');
 
  return $cart[$id];
 }
 
 public function atualiza(){
 
TSession::setValue('cart',$this->cart);
 }
 

 
 }// fim class

?>