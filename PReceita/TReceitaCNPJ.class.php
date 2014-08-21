<?php
/**
 * Description TReceitaCNPJ
 * @version    1.1
 * @authos Alexandre E. Souza
 * @author     Alexandre E. Souza 
 * @license    http://www.gnu.org/licenses/gpl.html
 */
class TReceitaCNPJ 
{


// campos


private $razao;
private $fantasia;
private $natureza;
private $atividade_p;
private $atividade_s;
private $cep;
private $rua;
private $bairro;
private  $cidade;
private  $uf;
private $numero;
private $situacao;
private $inscricao;
private $dateAber;
private $complemento;
private $dataSituacaoCad;
private $motivoSitCad;
private $sitEsp;
private $dataSitEsp;

//configuração

    private  $cookieFile;
    private  $token;
    private  $imgCaptcha;
    private  $urlCaptcha;
    
    public function __construct() 
    {
        require_once('lib/Simple_html_dom.php');
	require_once('lib/Simple_html_dom_node.php');
        new TSession;
        
        TSession::setValue('id', session_id());
        $cookie = TSession::getValue('id');                     
      // $this->cookieFile = 'app/output/'.$cookie;        
        $this->cookieFile = $cookie;
        if(!file_exists($this->cookieFile))
	{
		$file = fopen($this->cookieFile, 'w');
		fclose($file);
	}                
        
            $this->token = self::getCaptchaToken();
            $this->imgCaptcha = $this->getCaptcha($this->getTokenIdCaptcha());
                
    }



   /**
     * getTokenIdCaptcha()
     * @return string id captcha
     */
    public function getTokenIdCaptcha()
    {
        return $this->token[0];
    }
    
     /**
     * getTokenValue()
     * @return string id captcha
     */
    public function getTokenValue()
    {
        return $this->token[1];
    }
    
    /**
     * getUrlCaptcha()
     */
    public function getUrlCaptcha()
    {
        return $this->urlCaptcha;
    }

    public function getImg(){
        return $this->imgCaptcha;
    }
/**
 * getCaptchaToken()
 * @return boolean/Array
 */
private function getCaptchaToken()
{
	
	$ch = curl_init('http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp?cnpj=');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
	$htmlResult = curl_exec($ch);
	if(!$htmlResult)
        {
		return false;
        }
	$html = new Simple_html_dom($htmlResult);
	$url_imagem = $tokenValue = '';
	$imgcaptcha = $html->find('img[id=imgcaptcha]');
	if(count($imgcaptcha))
	{
		foreach($imgcaptcha as $imgAttr)
                {
			$url_imagem = $imgAttr->src;
                }
		if(preg_match('#guid=(.*)$#', $url_imagem, $arr))
		{
			$idCaptcha = $arr[1];
			$viewstate = $html->find('input[id=viewstate]');
			if(count($viewstate))
			{
				foreach($viewstate as $inputViewstate)
                                {
			             $tokenValue = $inputViewstate->value;
                                }
			}
			if(!empty($idCaptcha) && !empty($tokenValue))
                        {
				return array($idCaptcha, $tokenValue);
                        }
			else
                        {
				return false;
                        }
		}
	}
}
    
  
    /**
     * getCaptha()
     * @return image Captha     
     */
     private function getCaptcha($idCaptcha)
    {        
        if(preg_match('#^[a-z0-9-]{36}$#', $idCaptcha))
        {
                $url = 'http://www.receita.fazenda.gov.br/scripts/captcha/Telerik.Web.UI.WebResource.axd?type=rca&guid='.$idCaptcha; 
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
                $imgsource = curl_exec($ch);
                curl_close($ch);
                if(!empty($imgsource))
                {
                       $img = imagecreatefromstring($imgsource);
                       $this->urlCaptcha = "app/output/captcha_{$idCaptcha}.jpg";
                       $imagem = imagejpeg($img, $this->urlCaptcha);
                       $this->imgCaptcha = $imagem;          
                }
        }
    }
    
 /* getHtmlCNPJ()
 * 
 * @param string $cnpj
 * @param string $captcha
 * @param string $captcha
 * @return string|boolean
 */
private function getHtmlCNPJ($cnpj, $captcha, $token)
{	
    
        $this->cookieFile = str_replace('app/output/', '',  $this->cookieFile); 
	if(!file_exists($this->cookieFile))
        {
		return false;
        }
        else
        {               
            $post = array
            (
                    'origem' => 'comprovante',
                    'search_type' 	=> 'cnpj',
                    'cnpj'    	=> $cnpj,
                    'captcha'   	=> $captcha,
                    'captchaAudio'	=> '',
                    'submit1'    	=> 'Consultar',
                    'viewstate' => $token
            );

            $data = http_build_query($post, NULL, '&');
            $cookie = array('flag' => 1);

            $ch = curl_init('http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
            curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookie, NULL, '&'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
            curl_setopt($ch, CURLOPT_REFERER, 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp?cnpj=');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $html = curl_exec($ch);
            curl_close($ch);
            return $html;
        }
}

       
         /**
     * parseHtmlCNPJ()
     * @param string $html
     * @return array Resultado
     */
    public function parseHtmlCNPJ($html)
{	
	$dom = new DomDocument();
	@$dom->loadHTML($html);
	$q = $dom->getElementsByTagName('font');
	$len = $q->length;
	$campos = array();

	for($i = 4; $i < $len; $i++)
	{
		if(!isset($q->item(($i+1))->nodeValue))
			break;

		$current = trim($q->item($i)->nodeValue);
		$prox = trim($q->item(($i+1))->nodeValue);
		
		if($current == 'NÚMERO DE INSCRIÇÃO')
			//$campos['numeroInsc'] = $prox;
		    $this->inscricao = $prox;
		if($current == 'DATA DE ABERTURA')
			//$campos['dataAber'] = $prox;
			$this->dateAber = $prox;
		    
		if($current == 'NOME EMPRESARIAL')
			//$campos['nomeEmpre'] = $prox;
		   $this->razao = $prox;
		   
		if($current == 'TÍTULO DO ESTABELECIMENTO (NOME DE FANTASIA)')
			//$campos['tituloEstab'] = $prox;
			$this->fantasia = $prox;
		
		if($current == 'CÓDIGO E DESCRIÇÃO DA ATIVIDADE ECONÔMICA PRINCIPAL')
		{
			//while(strcasecmp($prox, 'código e descrição das atividades econômicas secundárias'))
			/*
			while($prox != 'código e descrição das atividades econômicas secundárias')
			{
				$campos['codDescAtivEconPrin'][] = preg_replace('/[ ]{2,}/', '', $prox);
				$i++;
				$prox = strtolower(trim(utf8_decode($q->item(($i+1))->nodeValue)));
			}
			*/
			//$campos['codDescAtivEconPrin'] = $prox;
			$this->atividade_p = $prox;
		}
		
		if($current == 'CÓDIGO E DESCRIÇÃO DAS ATIVIDADES ECONÔMICAS SECUNDÁRIAS')
		{
			//while(strcasecmp($prox, 'código e descrição da natureza jurídica'))
			/*
			while($prox != 'código e descrição da natureza jurídica')
			{
				$campos['codDescAtivEconSec'][] = preg_replace('/[ ]{2,}/', '', $prox);
				$i++;
				$prox = strtolower(trim(utf8_decode($q->item(($i+1))->nodeValue)));
			}
			*/
		
			$campos['codDescAtivEconSec'] = $prox;
			
			$this->atividade_s = $prox;
			
		}
		
		if($current == 'CÓDIGO E DESCRIÇÃO DA NATUREZA JURÍDICA')
			//$campos['codDescNatJur'] = $prox;
			$this->natureza = $prox;
		if($current == 'LOGRADOURO')
			//$campos['logradouro'] = $prox;
		  $this->rua = $prox;
		if($current == 'NÚMERO')
			//$campos['numero'] = is_numeric($prox) ? $prox : 0;				
		$this->numero = is_numeric($prox) ? $prox : 0;
		if($current == 'COMPLEMENTO')			
			//$campos['complemento'] = $prox;
			$this->complemento = $prox;
	
		if($current == 'CEP')
			//$campos['cep'] = preg_replace('#[^0-9]+#', '', $prox);
			$this->cep = preg_replace('#[^0-9]+#', '', $prox);
			
		if($current == 'BAIRRO/DISTRITO')
			//$campos['bairro'] = $prox;
			$this->bairro = $prox;
			
		if($current == 'MUNICÍPIO')
			//$campos['municipio'] = $prox;
			$this->cidade = $prox;
			
		if($current == 'UF')
			//$campos['uf'] = $prox;
			$this->uf = $prox;
			
		if($current == 'SITUAÇÃO CADASTRAL')
			//$campos['sitCad'] = $prox;
			$this->situacao = $prox;
			
		if($current == 'DATA DA SITUAÇÃO CADASTRAL')
			//$campos['dataSitCad'] = $prox;
			
			$this->dataSituacaoCad = $prox;
		
		if($current == 'MOTIVO DE SITUAÇÃO CADASTRAL')
			//$campos['motivoSitCad'] = $prox;
			$this->motivoSitCad = $prox;
		if($current == 'SITUAÇÃO ESPECIAL')
			//$campos['sitEsp'] = $prox;
			$this->sitEsp = $prox;
		if($current == 'DATA DA SITUAÇÃO ESPECIAL')
			//$campos['dataSitEsp'] = $prox;
			$this->dataSitEsp = $prox;
	}
	
	/* essa parte aqui é opcional, é que usei ela no meu
	 * último sistema. Depois de pegar os dados do estabelecimento
	 * porque não pegar a latitude e longitude dele para poder
	 * mostrar um mapa dele pro usuário caso necessário. Tem também
	 * a parte que cria um mapa estático do google no servidor, mas
	 * optei por omitir aqui no script, qualquer coisa é só pedir via
	 * comentários
	 */
	if(count($campos) == 22)
	{ // pego a latitude+longitude
		$campos['latitude'] = $campos['longitude'] = '';
		$endereco = "{$campos['logradouro']}, {$campos['numero']} - {$campos['municipio']} - {$campos['uf']}, brasil";
		$urlGetLL = 'http://maps.google.com/maps/geo?q='.urlencode($endereco).'&output=csv';

		$ch = curl_init($urlGetLL);
		$geocode = curl_exec($ch);
		curl_close($ch);
		if(!empty($geocode))
		{
			$geocodeArray = explode(',', $geocode);
			if(count($geocodeArray) == 4 && $geocodeArray[0] != '602')
			{
				$campos['latitude'] = $geocodeArray[2];
				$campos['longitude'] = $geocodeArray[3];
			}
		}
	}
	
	//return $campos;
}

    /**
     * @return mixed
     */
    public function getAtividadeP()
    {
        return $this->atividade_p;
    }

    /**
     * @return mixed
     */
    public function getAtividadeS()
    {
        return $this->atividade_s;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @return mixed
     */
    public function getDataSitEsp()
    {
        return $this->dataSitEsp;
    }

    /**
     * @return mixed
     */
    public function getDataSituacaoCad()
    {
        return $this->dataSituacaoCad;
    }

    /**
     * @return mixed
     */
    public function getDateAber()
    {
        return $this->dateAber;
    }

    /**
     * @return mixed
     */
    public function getFantasia()
    {
        return $this->fantasia;
    }

    /**
     * @return mixed
     */
    public function getInscricao()
    {
        return $this->inscricao;
    }

    /**
     * @return mixed
     */
    public function getMotivoSitCad()
    {
        return $this->motivoSitCad;
    }

    /**
     * @return mixed
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return mixed
     */
    public function getRazao()
    {
        return $this->razao;
    }

    /**
     * @return mixed
     */
    public function getRua()
    {
        return $this->rua;
    }

    /**
     * @return mixed
     */
    public function getSitEsp()
    {
        return $this->sitEsp;
    }

    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }



    /**
     * showResult()
     * @param string $cnpj
     * @param string $captcha
     * @param string $token
     * @return array $campos
     */
    public function showResult($cnpj, $captcha, $token)
    {       	
	$getHtmlCNPJ = $this->getHtmlCNPJ($cnpj, $captcha, $token);
	if($getHtmlCNPJ)
	{             
		$campos = $this->parseHtmlCNPJ($getHtmlCNPJ);              
                return $campos;
	}
    }

}
  
?>
