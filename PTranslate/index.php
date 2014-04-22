<?php

require './TTranslate.php';

$t = new TTranslate('en');
$t->setTags(TRUE);

// caso não set o idioma ele pega o usado no navegador de padrão
$t->setIdioma('pt');

 echo $t->translator('
Atuando no mercado há quase dois anos, a Sky Brasil Comunicação e Marketing já 
reúne em seu portifólio empresas de peso
 que optaram por investir em ações de marketing.   
    Priorizando soluções práticas, dinâmicas e criativas,
     a Sky Brasil Comunicação e Marketing vem alcançando um 
     resultado muito satisfatório junto as empresas que acreditam 
     nesse serviço. Para a equipe Sky Brasil Comunicação e Marketing a 
     construção de uma idéia, tem muito a ver com a comunicação, que somada 
     a uma relação mais estreita e afetiva resulta  em satisfação com o cliente final.  
         Com profissionais qualificados  em diversas áreas da comunicação, a Sky Brasil
          Comunicação e Marketing tem como objetivo agregar valores a cada projeto, 
          sempre usando muita criatividade e inovação.  
              A equipe garante todo o suporte para um bom atendimento,
               cumprindo com responsabilidade, mão de obra qualificada e os 
               melhores recursos para um trabalho eficaz

 	');
?>

