<?php


class PPagSeguro {

private $pg;
private $conta;
private $token;


public function setConta($conta){
	
	$this->conta = $conta;
}

public function setToken($token){

	$this->token = $token;
}

function __construct(){
	PagSeguroLibrary::init();
$this->pg = new PagSeguroPaymentRequest(); 

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
		
		throw new Exception('Objeto nгo й do tipo Cliente');
	}
	
	
	
}

public  function addCodVenda($cod){
	
	$this->pg->setReference($cod);
}


public function  addItem(PProduto $produto){
	
	if(get_class($produto) == 'PProduto'){
	
	$this->pg->addItem($produto->getId(),$produto->getNome(),$produto->getQtd(),$produto->getPreco());
	}else{
	
		throw new Exception('Objeto nгo й do tipo PProduto');
	}
}
	
public function logar(){
	
	if(empty($this->conta)){
	
		throw new Exception('conta nгo est setada');
	}else{
	
		if(empty($this->token)){
	
			throw new Exception('token nгo est setada');
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
	
	// fazendo a requisiзгo a API do PagSeguro pra obter a URL de pagamento
	return $url = $this->pg->register($credentials);
	}


	public function getNotificacao(){
		
		$credentials = $this->logar();
	
		/* Tipo de notificaзгo recebida */
		$type = $_POST['notificationType'];
		
		/* Cуdigo da notificaзгo recebida */
		$code = $_POST['notificationCode'];
		
		
		/* Verificando tipo de notificaзгo recebida */
		if ($type === 'transaction') {
		
			/* Obtendo o objeto PagSeguroTransaction a partir do cуdigo de notificaзгo */
			$transaction = PagSeguroNotificationService::checkTransaction(
					$credentials,
					$code // cуdigo de notificaзгo
			);
			
			switch ($transaction->getStatus()){
				
				case 1:
					$status = "Aguardando pagamento";
					break;
					
			    case 2:
				   $status = "Em anбlise";
					break;
						
				case 3:
					$status = "Paga";
					break;
					
				case 4:
					$status = "Disponнvel";
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
	
	/* Cуdigo identificador da transaзгo  */
	$transaction_id = $transacao_id;
	
	/*
	 Realizando uma consulta de transaзгo a partir do cуdigo identificador
	para obter o objeto PagSeguroTransaction
	*/
	$transaction = PagSeguroTransactionSearchService::searchByCode(
			$credentials,
			$transaction_id
	);
	
	return $transaction;
}

}
?>