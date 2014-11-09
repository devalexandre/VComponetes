

<?php
/**
 * PTimer Widget
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @subpackage PForm
 * @author     Alexandre E. Souza
 */


class PTimerGrid {


public function __construct(){}
 public function gerar(){
 
try{
TTransaction::open('sample');

 $table = new PTableWriteHTML();
          $table->addRowTitle();
           $table->addCellTitle("Id",'center');
            $table->addCellTitle("Nome",'center');
             $table->addCellTitle("Telefone",'center');
              $table->addCellTitle("E-Mail",'center');

    $criterio = new TCriteria();


     

         $dados = Contatos::getObjects();
         
         foreach($dados as $contatos):
           $table->addRow();
     
         $table->addCell($contatos->id,'center','danger');
           $table->addCell($contatos->nome,'center');
           $table->addCell($contatos->telefone,'center');
           $table->addCell($contatos->email,'center');

endforeach;
TTransaction::close();
//abre o timer
if (ob_get_level() == 0) ob_start();

for ($i = 0; $i == $i; $i++){

   $table->renderize();
        ob_flush();
        flush();
        sleep(2);
}//fecha o timer
echo "Done.";

ob_end_flush();
  
       }catch(Exeption $e){
       
       echo $e->getMessage();
       }
       }
       }
       ?>
       
       
      