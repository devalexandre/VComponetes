<?php
/**
*@author Alexandre E. Souza
*class para pegar dados da reseita federal de PJ
*/


class PReceita{


private $razao;
private $fantasia;
private $natureza;
private $atividade_p;
private $atividade_s;
private $rua;
private $bairro;
private  $cidade;
private  $uf;
private $numero;
private $situacao;
private $url;

function __construct(){

define('COOKIELOCAL', str_replace('\\', '/', realpath('./')).'/');
@session_start();


}

public function getCaptcha($id){

$idCaptcha = $id;
if(preg_match('#^[a-z0-9-]{36}$#', $idCaptcha))
{
	$url = 'http://www.receita.fazenda.gov.br/scripts/captcha/Telerik.Web.UI.WebResource.axd?type=rca&guid='.$idCaptcha;
	/* poderiamos fazer simplemente
	* $imgsource = file_get_contents($url);
	* mas, para evitar possíveis problemas com allow_url_fopen
	* vamos usar somente curl pra garantir
	*/
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	
	$imgsource = curl_exec($ch);
	$tipo = curl_getinfo($ch,CURLINFO_CONTENT_TYPE);
	curl_close($ch);
	
	//echo $tipo ;exit();
	
	
	/* se tiver obtido sucesso em pegar a imagem
	* crio uma imagem a partir da string usando imagecreatefromstring
	* e seto o header para image/jpg e mando 
	* o browser exibir ela.
	* poderia usar curl_getinfo($ch) para analisar
	* CONTENT_TYPE retornado pelo servidor, pra garantir
	* que é uma imagem e o formato é jpg, pois caso
	* o id tenha expirado o server retorna um gif, então
	* deixo isso como exercício.
	*/
	if(!empty($imgsource))
	{
		$img = imagecreatefromstring($imgsource);
	//header('Content-type: '.$tipo);
	
    imagejpeg($imgsource);
	
		
	}
}
}

public function getCaptchaToken()
{
	$cookieFile = COOKIELOCAL.session_id();
	if(!file_exists($cookieFile))
	{
		$file = fopen($cookieFile, 'w');
		fclose($file);
	}
	
	$ch = curl_init('http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp?cnpj=');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
	$html = curl_exec($ch);

	//bem fiz a requisição via curl e vou assumir que ocorreu tudo ok, ou seja obtive um http code 200 e o html veio pra mim bonito.
	if(!$html)
		return false;

	//vou carregar a biblioteca PHP Simple HTML DOM Parser
	require_once('Simple_html_dom.php');
	require_once('Simple_html_dom_node.php');

	// carrego o html na biblioteca
	$html = new Simple_html_dom($html);

	// variáveis que vão guardar a url do captcha e o token
	$url_imagem = $tokenValue = '';

	// pra quem está acostumado com jquery vai achar isso bem familiar, vou pegar a imagem que possuir o id imgcaptcha
	$imgcaptcha = $html->find('img[id=imgcaptcha]');

	// verifico se pegou alguma coisa
	if(count($imgcaptcha))
	{
		// percorro o laço para conseguir extrair a informação que quero, nesse caso a url da imagem
		foreach($imgcaptcha as $imgAttr)
			$url_imagem = $imgAttr->src;
		
		// essa er eh pra pegar somente o id do captcha
		if(preg_match('#guid=(.*)$#', $url_imagem, $arr))
		{
			$idCaptcha = $arr[1];
			
			// aqui é onde eu pego o token da página
			$viewstate = $html->find('input[id=viewstate]');
			if(count($viewstate))
			{
				foreach($viewstate as $inputViewstate) 
					$tokenValue = $inputViewstate->value;
			}
			
			// caso tenha pego $idCaptcha e $tokenValue eu retorno eles num array
			if(!empty($idCaptcha) && !empty($tokenValue))
				return array($idCaptcha, $tokenValue);
			else
				return false;
		}
	}
}

/* getHtmlCNPJ
 * 
 * @param string $cnpj
 * @param string $captcha
 * @param string $captcha
 * @return string|boolean
 */
public function getHtmlCNPJ($cnpj, $captcha, $token)
{
	// aqui é aquele arquivo onde salvei os cookies lá em getCaptchaToken()
	$cookieFile = COOKIELOCAL.session_id();
	if(!file_exists($cookieFile))
		return false;
	
	// aqui seto os campos que vou efetuar post pro server da RF
	$post = array
	(
		'origem' => 'comprovante',
		'search_type' 	=> 'cnpj',
		'cnpj'    		=> $cnpj,
		'captcha'   	=> $captcha,
		'captchaAudio'			=> '',
		'submit1'    	=> 'Consultar',
		'viewstate' => $token
	);
	
	$post = http_build_query($post, NULL, '&');

	// tenho que enviar esse cookie pra eles
	$cookie = array('flag' => 1);
	
	$ch = curl_init('http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
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



/* parseHtmlCNPJ
 * vai analisar/parsear o html e retorna os campos
 * caso consiga extrair-lo com sucesso. Observem
 * que usei a classe DomDocument presente na própria LP
 * pois apesar da simplicidade que a biblioteca simple html dom parser
 * me proporciona, ela é meio pesadinha e também
 * afim de inseri-lo neste mundo de bot, queria lhe
 * mostrar outras possibilidades para fazer a mesma coisa
 * 
 * 
 * @param string $html
 * @return array
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
			$campos['numeroInsc'] = $prox;
		
		if($current == 'DATA DE ABERTURA')
			$campos['dataAber'] = $prox;
		
		if($current == 'NOME EMPRESARIAL')
			$campos['nomeEmpre'] = $prox;
		
		if($current == 'TÍTULO DO ESTABELECIMENTO (NOME DE FANTASIA)')
			$campos['tituloEstab'] = $prox;
		
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
			$campos['codDescAtivEconPrin'] = $prox;
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
		}
		
		if($current == 'CÓDIGO E DESCRIÇÃO DA NATUREZA JURÍDICA')
			$campos['codDescNatJur'] = $prox;
			
		if($current == 'LOGRADOURO')
			$campos['logradouro'] = $prox;
		
		if($current == 'NÚMERO')
			$campos['numero'] = is_numeric($prox) ? $prox : 0;				
		
		if($current == 'COMPLEMENTO')			
			$campos['complemento'] = $prox;
	
		if($current == 'CEP')
			$campos['cep'] = preg_replace('#[^0-9]+#', '', $prox);
			
		if($current == 'BAIRRO/DISTRITO')
			$campos['bairro'] = $prox;
			
		if($current == 'MUNICÍPIO')
			$campos['municipio'] = $prox;
			
		if($current == 'UF')
			$campos['uf'] = $prox;
			
		if($current == 'SITUAÇÃO CADASTRAL')
			$campos['sitCad'] = $prox;
			
		if($current == 'DATA DA SITUAÇÃO CADASTRAL')
			$campos['dataSitCad'] = $prox;
			
		if($current == 'MOTIVO DE SITUAÇÃO CADASTRAL')
			$campos['motivoSitCad'] = $prox;
			
		if($current == 'SITUAÇÃO ESPECIAL')
			$campos['sitEsp'] = $prox;
			
		if($current == 'DATA DA SITUAÇÃO ESPECIAL')
			$campos['dataSitEsp'] = $prox;
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
	
	return $campos;
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
    public function getCidade()
    {
        return $this->cidade;
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



} 

?>