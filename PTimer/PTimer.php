

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


class PTimer
{


    protected $criteria;
    protected $model;
    protected $obj;
    protected $banco;
    protected $status;
    protected $timer;


    public function __construct($banco, $model,$criteria,$timer){

        $this->model = $model;
        $this->criteria = $criteria;
        $this->banco = $banco;
        $this->timer = $timer;
    }

    public function start()
    {
        $this->status = true;
        
      while($this->status){
            try {

                TTransaction::open($this->banco);

                $repo = new TRepository($this->model);
                $this->obj = $repo->load($this->criteria);

                TTransaction::close();

                if($this->obj) {


                    return $this->obj;
                    $this->status = false;
                }
            } catch (Exception $e) {
                throw new Exception();
            }

          sleep($this->timer);
        }
    }



}

?>