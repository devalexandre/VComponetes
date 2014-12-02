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
		$cep = str_replace('-','',$cep);
		$url = 'http://cep.republicavirtual.com.br/web_cep.php?cep='.$cep.'&formato=query_string';
		$ch = curl_init($url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		
    $resultado = curl_exec($ch);
    

    if($resultado){
        
         parse_str($resultado, $retorno);


       
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
