<?php


class PPagSeguro {

private $pg;
private $conta;
private $token;
private $moeda;
private $redirectURL;
private $itens;
private $reference;
private $url;
private $code;

function __construct($file){

	PagSeguroLibrary::init();
$this->pg = new PagSeguroPaymentRequest();

$this->init($file);
$this->moeda = "BRL";
$this->itens = array();
$this->pg->setCurrency($this->getMoeda());
}

public function getCode(){
return $this->code;
}

public function setMoeda($moeda ="BRL"){

$this->moeda = $moeda;

}

public function getMoeda(){

return $this->moeda;

}

public function setRedirectURL($url){

$this->redirectURL = $url;

}

public function getRedirectURL(){

if(empty($this->redirectURL)){
throw new Exception("preencha a redirectURL");
}else{
return $this->redirectURL;
}
}


public function addCliente(PCliente $cliente){
	
	
	if(get_class($cliente) == 'PCliente'){
		
		$this->pg->setSender($cliente->getNome(),$cliente->getMail());
		$this->pg->setShippingAddress(
				$cliente->getCep(),
				$cliente->getLogradouro(),
				$cliente->getNumero(),
				$cliente->getComplemento(),
				$cliente->getBairro(),
				$cliente->getCidade(),
				$cliente->getUf(),
				"BRA");
		
		$this->pg->setCurrency("BRL"); 
		$this->pg->setShippingType(3);
		
		
	}else{
		
		throw new Exception('Objeto nпїЅo пїЅ do tipo Cliente');
	}
	
	
	
}

public  function addCodVenda($cod){
	
	$this->pg->setReference($cod);
	

}



public function  addItem(PProduto $produto){
	
	if(get_class($produto) == 'PProduto'){
	
	$this->pg->addItem($produto->getId(),$produto->getNome(),$produto->getQtd(),$produto->getPreco());
	$this->itens[] = $produto;
	}else{
	
		throw new Exception('Objeto nпїЅo пїЅ do tipo PProduto');
	}
}
	
public function logar(){
	
	if(empty($this->conta)){
	
		throw new Exception('conta nпїЅo est setada');
	}else{
	
		if(empty($this->token)){
	
			throw new Exception('token nпїЅo est setada');
		}else{
	
	
			// Informando as credenciais
			$credentials = new PagSeguroAccountCredentials(
					$this->conta,
					$this->token
			);
			
			
			return $credentials;
		}
	}
	
}

public function getUrl(){
	

	$credentials = $this->logar();
	

	return $url = $this->pg->register($credentials);


}

    public function getButton(){

        try{
        $credentials = $this->logar();


        return $url = $this->pg->register($credentials);

    }catch (PagSeguroServiceException $e){

        print_r($e->getErrors());

        }
    }


	public function getNotificacao(){
		
		$credentials = $this->logar();
	
		/* Tipo de notificaпїЅпїЅo recebida */
		$type = $_POST['notificationType'];
		
		/* CпїЅdigo da notificaпїЅпїЅo recebida */
		$code = $_POST['notificationCode'];
		
		
		/* Verificando tipo de notificaпїЅпїЅo recebida */
		if ($type === 'transaction') {
		
			/* Obtendo o objeto PagSeguroTransaction a partir do cпїЅdigo de notificaпїЅпїЅo */
			$transaction = PagSeguroNotificationService::checkTransaction(
					$credentials,
					$code // cпїЅdigo de notificaпїЅпїЅo
			);
			
			switch ($transaction->getStatus()){
				
				case 1:
					$status = "Aguardando pagamento";
					break;
					
			    case 2:
				   $status = "Em anпїЅlise";
					break;
						
				case 3:
					$status = "Paga";
					break;
					
				case 4:
					$status = "DisponпїЅvel";
					break;
						
				case 5:
					$status = "Em disputa";
					break;
					
			case 6:
				$status = "Devolvida";
				break;
				
				case 7:
					$status = "Canselada";
					break;
			}
			
			return array('status' => $status,'IdTransacao' => $transaction->getCode());
	}


}


public  function getDados($transacao_id){
	
	$credentials = $this->logar();
	
	/* CпїЅdigo identificador da transaпїЅпїЅo  */
	$transaction_id = $transacao_id;
	
	/*
	 Realizando uma consulta de transaпїЅпїЅo a partir do cпїЅdigo identificador
	para obter o objeto PagSeguroTransaction
	*/
	$transaction = PagSeguroTransactionSearchService::searchByCode(
			$credentials,
			$transaction_id
	);
	
	return $transaction;
}

    private function init($file){
        // check if the database configuration file exists
        if (file_exists("app/config/{$file}.ini"))
        {
            // read the INI and retuns an array
            $db = parse_ini_file("app/config/{$file}.ini");



            $this->conta = $db['email'];
            $this->token= $db['token'];

$this->url = 'https://ws.pagseguro.uol.com.br/v2/checkout?email=' . $this->conta . '&token=' . $this->token;

        }
        else
        {
            // if the database doesn't exists, throws an exception
            throw new Exception(TAdiantiCoreTranslator::translate('File not found') . ': ' ."'{$database}.ini'");
        }
    }
    
    // faz a venda usando xml e curl_close
    public function MakeCurl(){
    
 #versao do encoding xml
$dom = new DOMDocument("1.0", "UTF-8");

#retirar os espacos em branco
$dom->preserveWhiteSpace = false;

#gerar o codigo
$dom->formatOutput = true;

#criando o nу principal (root)
$root = $dom->createElement("checkout");
$currency = $dom->createElement("currency", $this->pg->getCurrency());
$root->appendChild($currency);

$redirectURL = $dom->createElement("redirectURL", $this->getRedirectURL());  
$root->appendChild($redirectURL);
 
 $itens = $dom->createElement("items");;
 
 foreach($this->itens as $produto):
 
 $itens->appendChild($this->addItensXml($dom,$produto));
 
 endforeach;
 $root->appendChild($itens);
 
 $reference = $dom->createElement('reference',	$this->pg->getReference());
  $root->appendChild($reference);
  $dom->appendChild($root);
    
    if(is_file("app/output/pagseguro/send/".$this->pg->getReference().".xml")){
    unlink("app/output/pagseguro/send/".$this->pg->getReference().".xml");
    }
    


 $dom->save("app/output/pagseguro/send/".$this->pg->getReference().".xml");
 
 
    }
    
    public function sendData(){
   
    $file = file_get_contents("app/output/pagseguro/send/".$this->pg->getReference().".xml");
 

 
  $curl = curl_init($this->url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, Array('Content-Type: application/xml; charset=UTF-8'));
curl_setopt($curl, CURLOPT_POSTFIELDS, $file);
$xml= curl_exec($curl);

$urlRetorn = 'app/output/pagseguro/return/'.$this->pg->getReference().'.xml';


if(file_exists($urlRetorn)){

            unlink('app/output/pagseguro/return/'.$this->pg->getReference().'.xml');

        }
$retorno = fopen('app/output/pagseguro/return/'.$this->pg->getReference().'.xml','w+');
 
  fwrite($retorno,$xml);


if(curl_errno($curl))
{
    echo 'Curl error: ' . curl_error($curl);
}


if($xml == 'Unauthorized'){
    //Insira seu cуdigo avisando que o sistema estб com problemas, sugiro enviar um e-mail avisando para alguйm fazer a manutenзгo 

  new TMessage('error',"o Sistema temporariamente fora do ar");
}

curl_close($curl);


}

public function gerarUrl(){

$urlXml = 'app/output/pagseguro/return/'.$this->pg->getReference().'.xml';

$file = simplexml_load_file($urlXml);


$this->code = $file[0]->code;


$url = 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' .$file[0]->code;

return $url;

}
    
    private function addItensXml($dom,PProduto $itens){
    

    $root = $dom->createElement("item");
    $id = $dom->createElement("id",$itens->getId());
    $description = $dom->createElement("description",$itens->getDescricao());
    $amount = $dom->createElement("amount",$itens->getPreco());
    $quantity = $dom->createElement("quantity",$itens->getQtd());
    $weight = $dom->createElement("weight",$itens->getPeso());
  
    $root->appendChild($id);
    $root->appendChild($description); 
    $root->appendChild($amount); 
    $root->appendChild($quantity);        
    $root->appendChild($weight);   
    
    return  $root;     
    }

}
?>