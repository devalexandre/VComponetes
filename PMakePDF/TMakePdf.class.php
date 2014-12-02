<?php



class TMakePdf {


private $user;
private $code;

function __construct($code,$user){
$this->user = $user;
$this->code = $code;

}
function WritePDF($html){

 

$postfields = array('html'=>$html,'user'=>$this->user,'code'=>$this->code);

$pagina = "http://progs.net.br/webservice/engine.php?class=Progs&method=makePDF";
 
$ch = curl_init();
 
curl_setopt( $ch, CURLOPT_URL, $pagina );
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $postfields );
 
curl_exec( $ch );
 


if(curl_exec($ch) === false)
{
    echo 'Curl error: ' . curl_error($ch);
}


curl_close($ch);

}


function openPDF($dir){

$file = file_get_contents("http://progs.net.br/webservice/app/reports/{$this->user}/{$this->user}.pdf");
$output = $dir."/".date('h_m_s').".pdf";


file_put_contents($output, $file);

return $output;

}


}
?>