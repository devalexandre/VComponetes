<?php


class PPieChartFull extends TElement{

private $data;
private $chart;
private $colunas;
private $img;
private $titulo;
private $dados;
private $d3;
private $slices;
private $slicesColumns;


public function __construct($width,$height){

parent::__construct('iframe');


$this->width = "$width";
$this->height = "$height";
 $this->style = "border:0;";
 $this->id = 'pie'.uniqid();
}

/**
@see $slices, boolean
@see legenda legenda da slice
@see radio distancia usada
*/

public function setSlices($slices = false,$legenda = "My Chart",$radio){

if($slices){
$i = 0;
$distancia = "";
foreach($this->slicesColumns as $c):
$distancia .= " $i: {offset: $radio[$i]},";
$i++;
endforeach;
$this->slices = "  legend: '$legenda',
          pieSliceText: 'label',
          slices: { 
          $distancia
          },
";

}
}

public function set3d($d3 = false){

if($d3){
$this->d3 = " , is3D: true,";
}}

/**
*@see Array ,
*/
public function setColunas($colunas){
$i = 0;
$this->slicesColumns = $colunas;
foreach($colunas as $c):
if($i == 0){
$this->colunas = "'$c'";

}else{
$this->colunas .= ",'$c'";
}
$i++;
endforeach;
}

/**
*@see Array ,
*/
public function setDados($dados){
$i = 0;

foreach($dados as $d => $v):
if($i == 0){
$this->dados = "['$d',  $v]";

}else{
$this->dados .= ",['$d',  $v]";
}
$i++;
endforeach;

}

public function setTitulo($titulo){
$this->titulo = $titulo;
}



public function gerar(){

if(empty($this->colunas)){
throw new Exception('valor da coluna não pode ser nulo ou vazio');
}



if(empty($this->titulo)){
throw new Exception('valor do titulo não pode ser nulo ou vazio');
}


$jsapi = "<html>
  <head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          [$this->colunas],
  $this->dados
        ]);

        var options = {
        $this->slices
          title: '$this->titulo'
          $this->d3
        };
        
   


        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        var img_chart = document.getElementById('img');
       
     
       
        chart.draw(data, options);
        
        
      }
    </script>
  </head>
  <body>
    <div id='piechart' style='width:$this->width; height: $this->height;'></div>

  </body>
</html>
";

if(file_exists('app/reports/piechart.html')){

            unlink('app/reports/piechart.html');

        }
$grafico = fopen('app/reports/piechart.html','w+');
 
  fwrite($grafico,$jsapi);


$this->width = "100%";
$this->height = "600px";
$this->src = "app/reports/piechart.html" ;


}
 public function show(){

        parent::show();
    }
}
?>