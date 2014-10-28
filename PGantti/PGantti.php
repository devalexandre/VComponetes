<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/27/14
 * Time: 2:07 PM
 */

class PGantti extends TElement{


    private   $project;
    protected $local;
    private $titulo;


    function __construct($local = 'pt_BR'){

        require_once("lib/gantti.php");

        parent::__construct('iframe');
        $this->style = "border:0;";
       $this->data = array();


   

        date_default_timezone_set('UTC');
        if($local = 'pt_BR'){
        setlocale(LC_ALL, $local ,'ptb');
        }else{
            setlocale(LC_ALL, $local);
        }


    }


    public function addProject(PProject $project){


        $this->project[] = $project;




    }


    public function gerar($titulo, $time = false){


        $data = array();



        foreach($this->project as $project):

            if(strtotime($project->getEnd()) > strtotime($project->getStart())){
            $data[] =  array(
                'label' => $project->getLabel(),
                'start' => $project->getStart(),
                'end'   => $project->getEnd(),
                'class' => $project->getPriority(),
                'timeStart' => $project->getTimeStart(),
                'timeEnd' => $project->getTimeEnd()

            );
             }else{

                throw new ErrorException(' A data final é menor que a data inicial no objeto: '.$project->getLabel());
            }
            endforeach;



     $gantti = new Gantti( $data, array(
            'title'      => $titulo,
            'cellwidth'  => 25,
            'cellheight' => 35,

              'time' =>$time

        ));


        if(file_exists('app/reports/gantti.html')){

            unlink('app/reports/gantti.html');

        }
$grafico = fopen('app/reports/gantti.html','w+');



        $link1 = '<link rel="stylesheet" href="../lib/PComponetes/PGantti/styles/css/screen.css" />';
        $link2 = '<link rel="stylesheet" href="../lib/PComponetes/PGantti/styles/css/gantti.css" />';

        fwrite($grafico,$link1);
        fwrite($grafico,$link2);

    fwrite($grafico,$gantti);


$this->width = "100%";
$this->height = "600px";
$this->src = "app/reports/gantti.html" ;

    }

    public function show(){

        parent::show();
    }

}


