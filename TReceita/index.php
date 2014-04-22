
<?php

require_once("TReceita.class.php");


$PJ = new TReceita();

if(isset($_POST['cnpj'])){
$cnpj = $_POST['cnpj'];
	$captcha = $_POST['captcha'];
	$token = $_POST['viewstate'];
	
	$getHtmlCNPJ = $PJ->getHtmlCNPJ($cnpj, $captcha, $token);
	if($getHtmlCNPJ)
	{
		$campos = $PJ->parseHtmlCNPJ($getHtmlCNPJ);
		// evite <pre>, seja criativo e não preguiçoso como eu. srs
		echo '<pre>';
		print_r($campos);
		echo '</pre>';
	}
}

$getCaptchaToken = $PJ->getCaptchaToken();
	
	// pf, seja mais criativo
	if(!is_array($getCaptchaToken))
	{
		echo 'Não foi possível obter Captcha e Token';
		exit;
	}
	
	 print_r($PJ->getCaptcha($getCaptchaToken[0])); 
	 exit();
	
?>

<html>
	<head>
		<title>CNPJ e Captcha</title>
	</head>
	<body>
		<form method="post" action="processa.php">
			<span class="titleCats">CNPJ e Captcha</span>
			<br />
			<input name="cnpj" type="text" maxlength="14" required /> <b style="color: red">CNPJ</b>
			<br />
			<img src="<?php echo $PJ->getCaptcha($getCaptchaToken[0]); ?>" border="0">
			<br />
			<input name="captcha" type="text" maxlength="6" required />
			<b style="color: red">O que vê na imagem acima?</b>
			<br />
			<input type="hidden" name="viewstate" value="<?php echo $getCaptchaToken[1]; ?>" />
			<br/>
			<input type="submit" value="Enviar"/>
		</form>
	</body>
</html>