<?php


class PTxt{

private $file;
private $line = array();

public function __construct($file){

$this->file = $file;

}


public function readLines(){
$arquivo = fopen($this->file,'r');
if ($arquivo == false){
throw new Exception('não foi possivel ler o arquivo');
}
while(true) {
	$linha = fgets($arquivo);
	if ($linha==null) break;
	$this->line[] = $linha;
}
fclose($arquivo);

return $this->line;
} 



}
?>