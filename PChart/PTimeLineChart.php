<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/29/14
 * Time: 2:20 PM
 */

class PTimeLineChart extends TElement{

    private $chart;
    private $color;
    private $data;
    private $title;
    private $size;
    private $dataMultiple;



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
        if(empty($this->color)){

            throw new Exception('preencha a cor com setColor');
        }else{
            return $this->color;
        }
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


    public function addData($mes,$data){

        $this->dataMultiple[$mes] = $data;
    }

    public function debug(){

        var_dump($this->dataMultiple);
        exit;
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


        $this->chart->setChartAttrs( array(
            'type' => 'sparkline',
            'title' => $this->title,
            'data' => $this->dataMultiple,
            'size' => $this->size,
            'color' => $this->getColor(),
            'labelsXY' => true,
           // 'fill' => array( '#eeeeee', '#aaaaaa' ),
        ));

        $this->add("$this->chart");


        parent::show();
    }
}