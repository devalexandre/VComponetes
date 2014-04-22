<?php


/**
 * PMaskFormate 
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @author     Alexandre E. Souza
 
 */
 
class PTranslate {
    
    
   private $entrada = NULL;
   private $saida;
    private $word;
    private $type;
    private $tags;
  
/*    
    VALOR | IDIOMA
en|de | Inglês para Alemão
en|es | Inglês para Espanhol
en|fr | Inglês para Francês
en|it | Inglês para Italiano
en|pt | Inglês para Português
de|en | Alemão para Inglês
de|fr | Alemão para Francês
es|en | Espanhol para Inglês
fr|en | Francês para Inglês
fr|de | Francês para Alemão
it|en | Italiano para Inglês
pt|en | Português para Inglês
*/
    
    public function __construct($saida = NULL,$entrada = null,$word= null) {
        
        if($entrada){
            $this->entrada = $entrada;
        }
          if($saida){
            $this->saida = $saida;
        }
        if($word){
            $this->word = $word;
        }
    }
      
    
    
    


function translator($word= null,$saida = NULL) {
        
        if($this->entrada == NULL){
     
         $this->entrada = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
   
        }
          if($saida){
            $this->saida = $saida;
        }
        if($word){
            $this->word = $word;
        }
        
        //======= [ Tratar Endereço ] ==============================
 
        $UrlTranslate = parse_url("http://translate.google.com/translate_t");
        $DataReceived  = " ";
 
        $post_google = array('sl' => $this->entrada, 'tl' => $this->saida ,'text' => utf8_encode(($this->word)));      
        $post_google = http_build_query(($post_google));
 
        //======= [ Abrir a conexão ] ====================
        $TranslateSock = fsockopen($UrlTranslate['host'], 80, $errno, $errstr, 30);    
 
        if (!$TranslateSock)
        {
                fclose($TranslateSock);
                die("[ERRO] Erro de conexão, verifique o pedido");
        }
 
        fputs($TranslateSock, "POST ". $UrlTranslate['path'] . " HTTP/1.1\r\n");
        fputs($TranslateSock, "Host: " . $UrlTranslate['host'] . " \r\n");
 
        fputs($TranslateSock, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($TranslateSock, "Content-length: ". strlen($post_google) ."\r\n");
        fputs($TranslateSock, "Connection: close\r\n\r\n");
        fputs($TranslateSock, $post_google);
 
        while(!feof($TranslateSock))
        {
                $DataReceived .= fgets($TranslateSock, 128);
        }
        fclose($TranslateSock);
 
        //======= [ Tratar resposta ] ====================
        $this->Type();
        
        if($this->type == 'short_text'){
        $DataReceived = explode("short_text", $DataReceived);
        $DataReceived[1] = substr($DataReceived[1] ,2, -(strlen($DataReceived[1]) - strpos($DataReceived[1], "</span>")));
       
        }
        
        if($this->type == 'long_text'){
       
          $DataReceived = explode("long_text", $DataReceived);
         $DataReceived[1] = substr($DataReceived[1] ,2, -(strlen($DataReceived[1]) - strpos($DataReceived[1], "<div id=gt-res-ex>")));
        }
        
        if($this->tags){
            return strip_tags($DataReceived[1]);
        }else{
              return $DataReceived[1];
        }
      
}



final  function Type(){
    
   

    if(strlen(trim($$this->word)) < 255){
        $this->type = 'short_text';
    }else{
        $this->type = 'long_text';
    }
}

/**
 * @example TRUE mostra as tags html no retorno
 * @example FALSE retira as tags html no retorno
 * @param Boolean $tag
 */
final function setTags($tag = FALSE){
    
    if($tag){
        $this->tags = TRUE;
    }else{
        $this->tags =FALSE;
    }
}

/**
 * @example pt para saida em portugues
 * @param String $entrada
 * @see seta qual a lingua padrão do usuario
 */
final function setIdioma($entrada = NULL){
    if($entrada){
        $this->entrada = $entrada;
    }else{
         $this->entrada = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
    }
   

}
}

?>
