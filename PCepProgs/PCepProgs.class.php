<?php

/**
 * PCepProgs 
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @author     Alexandre E. Souza
 
 */


class PCepProgs
{

 
  private $rua;
  private $bairro;
  private $cidade;
  private $uf;


function __construct($cep){

		if(isset($cep)){
    $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
    

    if($resultado){
        
         parse_str($resultado, $retorno);


        exit;
    $this->rua = $retorno['logradouro'] ;
    $this->bairro = $retorno['bairro'] ;
    $this->cidade = $retorno['cidade'] ;
    $this->uf = $retorno['uf'] ;
    }else{

    	throw new Exception("Sem Conexao com a internet");
    	
    }}else{

    	throw new Exception("Cep Em branco");
    }
   

}



public function getRua(){

	return $this->rua;
}

public function getBairro(){

	return $this->bairro;
}

public function getCidade(){

	return $this->cidade;
}

public function getUf(){

	return $this->uf;
}




}
