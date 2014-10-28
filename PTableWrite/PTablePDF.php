<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 10/25/14
 * Time: 2:24 AM
 */

class PTablePDF {
   
    private $pdf;



    /**
     * Método construtor
     * @param $widths vetor contendo as larguras das colunas
     */
    public function __construct()
    {



 }
 
 /**
     * Armazena o conteúdo do documento em um arquivo
     * @param $filename caminho para o arquivo de saída
     */
    public function save($file,$filename)
    {
    
    try{
   // define('DOMPDF_ENABLE_AUTOLOAD', true);
    
require_once("dompdf/dompdf_config.inc.php");


$this->pdf =  new DOMPDF();

    $contents = file_get_contents($file);
    

  $this->pdf->load_html($contents);
 //$this->pdf->set_paper('letter', 'portraite');
$this->pdf->render();

 file_put_contents("app/reports/{$filename}.pdf", $this->pdf->output());
   
    }catch(Exception $e){
    
    echo $e->getMessage();
    }
    }

}