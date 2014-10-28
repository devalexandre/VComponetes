<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/30/14
 * Time: 2:35 AM
 */


class PDataGrid extends TDataGrid{

    protected $class;


    public function __construct($type = "table-hover"){
        parent::__construct();

        TPage::include_css('app/lib/PComponetes/util/css/bootstrap.css');

        $this->class = "table $type";
    }
} 