<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/30/14
 * Time: 2:35 AM
 */


class PDataGrid {

    protected $class;
    protected $datagrid;
    protected $timer;
    protected $colum;
    protected $status;
    protected $time;



    public function __construct($banco, $model,$criteria,$timer){


        TPage::include_css('app/lib/PComponetes/util/css/bootstrap.css');

        $this->datagrid = new TQuickGrid();
        $this->datagrid->class = "table table-hover";
        $this->timer = new PTimer($banco, $model,$criteria,$timer);
$this->time = $timer;
    }


    public function addColum(Array $column){

        $this->colum = $column;

        foreach($column as $colum => $value):
            $this->datagrid->addQuickColumn($colum,    $value,    'left', 20);
            endforeach;
    }

    public function addAction($label, TDataGridAction $action, $field, $icon = NULL){

        $this->datagrid->addQuickAction($label,$action, $field, $icon = NULL);
    }

    public function create(){

        $this->status = true;
        do {
            $obj = $this->timer->start();

            $this->datagrid->clear();
            $this->datagrid->createModel();
            if ($obj) {
                // coloca os dados na grid
                foreach ($obj as $itens):


                    $this->datagrid->addItem($itens);

                endforeach;
            }

            return $this->datagrid;

sleep(30);
        }while($this->status);



    }
} 