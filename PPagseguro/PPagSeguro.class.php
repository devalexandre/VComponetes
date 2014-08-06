<?php


class PPagSeguro {

private $pg;
private $conta;
private $token;


function __construct($file){

	PagSeguroLibrary::init();
$this->pg = new PagSeguroPaymentRequest();

$this->init($file);

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
		
		throw new Exception('Objeto n�o � do tipo Cliente');
	}
	
	
	
}

public  function addCodVenda($cod){
	
	$this->pg->setReference($cod);
}


public function  addItem(PProduto $produto){
	
	if(get_class($produto) == 'PProduto'){
	
	$this->pg->addItem($produto->getId(),$produto->getNome(),$produto->getQtd(),$produto->getPreco());
	}else{
	
		throw new Exception('Objeto n�o � do tipo PProduto');
	}
}
	
public function logar(){
	
	if(empty($this->conta)){
	
		throw new Exception('conta n�o est setada');
	}else{
	
		if(empty($this->token)){
	
			throw new Exception('token n�o est setada');
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
	
		/* Tipo de notifica��o recebida */
		$type = $_POST['notificationType'];
		
		/* C�digo da notifica��o recebida */
		$code = $_POST['notificationCode'];
		
		
		/* Verificando tipo de notifica��o recebida */
		if ($type === 'transaction') {
		
			/* Obtendo o objeto PagSeguroTransaction a partir do c�digo de notifica��o */
			$transaction = PagSeguroNotificationService::checkTransaction(
					$credentials,
					$code // c�digo de notifica��o
			);
			
			switch ($transaction->getStatus()){
				
				case 1:
					$status = "Aguardando pagamento";
					break;
					
			    case 2:
				   $status = "Em an�lise";
					break;
						
				case 3:
					$status = "Paga";
					break;
					
				case 4:
					$status = "Dispon�vel";
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
	
	/* C�digo identificador da transa��o  */
	$transaction_id = $transacao_id;
	
	/*
	 Realizando uma consulta de transa��o a partir do c�digo identificador
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


        }
        else
        {
            // if the database doesn't exists, throws an exception
            throw new Exception(TAdiantiCoreTranslator::translate('File not found') . ': ' ."'{$database}.ini'");
        }
    }

}
?>