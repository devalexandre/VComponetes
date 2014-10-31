<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/29/14
 * Time: 11:47 AM
 */

class PPieChart extends TElement{

    private $chart;
    private $color;
    private $data;
    private $title;
    private $size;



    function __construct(){

        parent::__construct('div');

        require_once('lib/GoogChart.class.php');

        $this->chart = new GoogChart();
        


    }



    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function getData()
    {

        return $this->data;
    }




    /**
     * @param Array $color
     * @see
     */
    public function setColor($color)
    {
        if(is_array($color)){
            $this->color = $color;
        }else{

            throw new Exception('a variavel $color deve ser um array');
        }


    }

    /**
     * @param Array $data
     */
    public function setData($data)
    {

        if(is_array($data)){

            $this->data = $data;

        }else{

            throw new Exception('a variavel $data deve ser um array');
        }
    }

    /**
     * @param mixed $size
     */
    public function setSize($width,$height)
    {
        $this->size = array($width,$height);


    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }





    public function show(){
    
    
    $legenda  = new TElement('div');
    $i = 0;
    
    foreach($this->data as $dados => $valor):
    $p = new TElement('div');
      $p->add($dados." : ".$valor );
    $v = new TElement('div');
  
    $v->style = "background:".$this->color[$i].";width:5px;height:5px";
    $p->add($v);
    
    $legenda->add($p);
    $i++;
    endforeach;



        $this->chart->setChartAttrs( array(
            'type' => 'pie',
            'title' => $this->title,
            'data' => $this->data,
            'size' => $this->size,
            'color' => $this->color,
            
            
         
        ));

$TVBox = new TVBox();
$TVBox->add($legenda);
$TVBox->add("$this->chart");


        $this->add($TVBox);


        parent::show();
    }
    
    public function renderize(){
    
    $legenda  = new TElement('div');
    $i = 0;
    
    foreach($this->data as $dados => $valor):
    $p = new TElement('div');
      $p->add($dados." : ".$valor );
    $v = new TElement('div');
  
    $v->style = "background:".$this->color[$i].";width:5px;height:5px";
    $p->add($v);
    
    $legenda->add($p);
    $i++;
    endforeach;



        $this->chart->setChartAttrs( array(
            'type' => 'pie',
            'title' => $this->title,
            'data' => $this->data,
            'size' => $this->size,
            'color' => $this->color,
            
            
         
        ));

$TVBox = new TVBox();
$TVBox->add($legenda);
$TVBox->add("$this->chart");


        $this->add($TVBox);
        
        return $TVBox;
        }
} 