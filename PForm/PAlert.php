<?php


class PAlert extends TElement
{
    protected  $type; // image path
    protected $alert;
    protected $titulo;
    protected $msg;


    /**
     * Class Constructor
     * @param $source Image path
     */
    public function __construct($type = 'danger', $msg = 'alerta',$titulo = "Alerta")
    {
        TPage::include_js('app/lib/PComponetes/util/js/bootstrap.js');
        TPage::include_css('app/lib/PComponetes/util/css/bootstrap.css');

        parent::__construct('div');

        $this->setType($type);
        $this->titulo = $titulo;
        $this->msg = $msg;
        $this->class ="alert alert-dismissable $this->type ";
        $this->role = "alert";



    }


    public function setSize($width){


        $this->width = $width;

    }

    public function setTitulo($t){
        $this->titulo = $t;
    }


    public function setType($type){

        switch($type){



            case 'success':
                $this->type = 'alert alert-'.$type;
                break;

            case 'info':
                $this->type = 'alert alert-'.$type;
                break;

            case 'warning':
                $this->type = 'alert alert-'.$type;
                break;

            case 'danger':
                $this->type = 'alert alert-'.$type;
                break;



            default:
                $this->type = 'alert alert-danger';



        }

    }
    public function  setClass($class){

        $this->class= $class;
    }


    public function show(){



        $btn ='  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';


        $titulo = new TElement('h4');
        $titulo->add($this->titulo);

        $msg = new TElement('p');
        $msg->add($this->msg);


        $this->add($btn);
        $this->add($titulo);
        $this->add($msg);

        parent::show();
    }
}
?>