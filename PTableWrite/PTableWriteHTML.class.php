<?php



class PTableWriteHTML
{

    public $table;
    public $tr;
     public $trT;
    public $thead;
    public $tbody;



    /**
     * Método construtor
     * @param $widths vetor contendo as larguras das colunas
     */
    public
    function __construct()
    {
    TPage::include_css('app/lib/PComponetes/util/table.min.css');
        // cria uma nova tabela
        $this->table = new TElement('table');
        $this->table->cellspacing = 0;
        $this->table->cellpadding = 0;
        $this->table->class = "ptable ptable-striped";

        $this->thead =  new TElement('thead');
        $this->tbody =  new TElement('tbody');
    }


    /**
     * Adiciona uma nova linha na tabela
     */
    public function addRow($class = null)
    {
        $this->tr = new TElement('tr');
        if(!is_null($class)){
        $this->tr->class = $class;
        }
        $this->tbody->add($this->tr);
    }
    
      public function addRowTitle($class = null)
    {
        $this->trT = new TElement('tr');
         if(!is_null($class)){
        $this->trT->class = $class;
        }
        $this->thead->add($this->trT);
    }

    /**
     * Adiciona uma nova célula na linha atual da tabela
     * @param $content   conteúdo da célula
     * @param $align     alinhamento da célula
     * @param $stylename nome do estilo a ser utilizado
     * @param $colspan   quantidade de células a serem mescladas
     */
    public
    function addCell($content, $align, $stylename = null, $colspan = 1)
    {

$td = new TElement('td');
        $td->add($content);
        if(!is_null($stylename)){
        $td->class = $stylename;
        }
        $td->style = "text-align: $align";
        $td->colspan = $colspan;

        $this->tr->add($td);
    }
    
      public
    function addCellTitle($content, $align, $stylename = 'active', $colspan = 1)
    {

$td = new TElement('th');
        $td->add($content);
        $td->class = $stylename;
        $td->style = "text-align: $align";
        $td->colspan = $colspan;

        $this->trT->add($td);
    }

    /**
     * Armazena o conteúdo do documento em um arquivo
     * @param $filename caminho para o arquivo de saída
     */
    public
    function save($filename)
    {
        $this->table->add($this->thead);
        $this->table->add($this->tbody);

        ob_start();
        echo "<html>\n";
echo "<head>\n";
        echo "<style type='text/css'>\n";
     echo 'table {
  background-color: transparent;
}
th {
  text-align: left;
}
.ptable {
  width: 100%;
  max-width: 100%;
  margin-bottom: 20px;
}
.ptable > thead > tr > th,
.ptable > tbody > tr > th,
.ptable > tfoot > tr > th,
.ptable > thead > tr > td,
.ptable > tbody > tr > td,
.ptable > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #dddddd;
}
.ptable > thead > tr > th {
  vertical-align: bottom;
  border-bottom: 2px solid #dddddd;
}
.ptable > caption + thead > tr:first-child > th,
.ptable > colgroup + thead > tr:first-child > th,
.ptable > thead:first-child > tr:first-child > th,
.ptable > caption + thead > tr:first-child > td,
.ptable > colgroup + thead > tr:first-child > td,
.ptable > thead:first-child > tr:first-child > td {
  border-top: 0;
}
.ptable > tbody + tbody {
  border-top: 2px solid #dddddd;
}
.ptable .ptable {
  background-color: #ffffff;
}
.ptable-condensed > thead > tr > th,
.ptable-condensed > tbody > tr > th,
.ptable-condensed > tfoot > tr > th,
.ptable-condensed > thead > tr > td,
.ptable-condensed > tbody > tr > td,
.ptable-condensed > tfoot > tr > td {
  padding: 5px;
}
.ptable-bordered {
  border: 1px solid #dddddd;
}
.ptable-bordered > thead > tr > th,
.ptable-bordered > tbody > tr > th,
.ptable-bordered > tfoot > tr > th,
.ptable-bordered > thead > tr > td,
.ptable-bordered > tbody > tr > td,
.ptable-bordered > tfoot > tr > td {
  border: 1px solid #dddddd;
}
.ptable-bordered > thead > tr > th,
.ptable-bordered > thead > tr > td {
  border-bottom-width: 2px;
}
.ptable-striped > tbody > tr:nth-child(odd) > td,
.ptable-striped > tbody > tr:nth-child(odd) > th {
  background-color: #f9f9f9;
}
.ptable-hover > tbody > tr:hover > td,
.ptable-hover > tbody > tr:hover > th {
  background-color: #f5f5f5;
}
table col[class*="col-"] {
  position: static;
  float: none;
  display: table-column;
}
table td[class*="col-"],
table th[class*="col-"] {
  position: static;
  float: none;
  display: table-cell;
}
.ptable > thead > tr > td.active,
.ptable > tbody > tr > td.active,
.ptable > tfoot > tr > td.active,
.ptable > thead > tr > th.active,
.ptable > tbody > tr > th.active,
.ptable > tfoot > tr > th.active,
.ptable > thead > tr.active > td,
.ptable > tbody > tr.active > td,
.ptable > tfoot > tr.active > td,
.ptable > thead > tr.active > th,
.ptable > tbody > tr.active > th,
.ptable > tfoot > tr.active > th {
  background-color: #f5f5f5;
}
.ptable-hover > tbody > tr > td.active:hover,
.ptable-hover > tbody > tr > th.active:hover,
.ptable-hover > tbody > tr.active:hover > td,
.ptable-hover > tbody > tr:hover > .active,
.ptable-hover > tbody > tr.active:hover > th {
  background-color: #e8e8e8;
}
.ptable > thead > tr > td.success,
.ptable > tbody > tr > td.success,
.ptable > tfoot > tr > td.success,
.ptable > thead > tr > th.success,
.ptable > tbody > tr > th.success,
.ptable > tfoot > tr > th.success,
.ptable > thead > tr.success > td,
.ptable > tbody > tr.success > td,
.ptable > tfoot > tr.success > td,
.ptable > thead > tr.success > th,
.ptable > tbody > tr.success > th,
.ptable > tfoot > tr.success > th {
  background-color: #dff0d8;
}
.ptable-hover > tbody > tr > td.success:hover,
.ptable-hover > tbody > tr > th.success:hover,
.ptable-hover > tbody > tr.success:hover > td,
.ptable-hover > tbody > tr:hover > .success,
.ptable-hover > tbody > tr.success:hover > th {
  background-color: #d0e9c6;
}
.ptable > thead > tr > td.info,
.ptable > tbody > tr > td.info,
.ptable > tfoot > tr > td.info,
.ptable > thead > tr > th.info,
.ptable > tbody > tr > th.info,
.ptable > tfoot > tr > th.info,
.ptable > thead > tr.info > td,
.ptable > tbody > tr.info > td,
.ptable > tfoot > tr.info > td,
.ptable > thead > tr.info > th,
.ptable > tbody > tr.info > th,
.ptable > tfoot > tr.info > th {
  background-color: #d9edf7;
}
.ptable-hover > tbody > tr > td.info:hover,
.ptable-hover > tbody > tr > th.info:hover,
.ptable-hover > tbody > tr.info:hover > td,
.ptable-hover > tbody > tr:hover > .info,
.ptable-hover > tbody > tr.info:hover > th {
  background-color: #c4e3f3;
}
.ptable > thead > tr > td.warning,
.ptable > tbody > tr > td.warning,
.ptable > tfoot > tr > td.warning,
.ptable > thead > tr > th.warning,
.ptable > tbody > tr > th.warning,
.ptable > tfoot > tr > th.warning,
.ptable > thead > tr.warning > td,
.ptable > tbody > tr.warning > td,
.ptable > tfoot > tr.warning > td,
.ptable > thead > tr.warning > th,
.ptable > tbody > tr.warning > th,
.ptable > tfoot > tr.warning > th {
  background-color: #fcf8e3;
}
.ptable-hover > tbody > tr > td.warning:hover,
.ptable-hover > tbody > tr > th.warning:hover,
.ptable-hover > tbody > tr.warning:hover > td,
.ptable-hover > tbody > tr:hover > .warning,
.ptable-hover > tbody > tr.warning:hover > th {
  background-color: #faf2cc;
}
.ptable > thead > tr > td.danger,
.ptable > tbody > tr > td.danger,
.ptable > tfoot > tr > td.danger,
.ptable > thead > tr > th.danger,
.ptable > tbody > tr > th.danger,
.ptable > tfoot > tr > th.danger,
.ptable > thead > tr.danger > td,
.ptable > tbody > tr.danger > td,
.ptable > tfoot > tr.danger > td,
.ptable > thead > tr.danger > th,
.ptable > tbody > tr.danger > th,
.ptable > tfoot > tr.danger > th {
  background-color: #f2dede;
}
.ptable-hover > tbody > tr > td.danger:hover,
.ptable-hover > tbody > tr > th.danger:hover,
.ptable-hover > tbody > tr.danger:hover > td,
.ptable-hover > tbody > tr:hover > .danger,
.ptable-hover > tbody > tr.danger:hover > th {
  background-color: #ebcccc;
}
@media screen and (max-width: 767px) {
  .ptable-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    overflow-x: auto;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #dddddd;
    -webkit-overflow-scrolling: touch;
  }
  .ptable-responsive > .ptable {
    margin-bottom: 0;
  }
  .ptable-responsive > .ptable > thead > tr > th,
  .ptable-responsive > .ptable > tbody > tr > th,
  .ptable-responsive > .ptable > tfoot > tr > th,
  .ptable-responsive > .ptable > thead > tr > td,
  .ptable-responsive > .ptable > tbody > tr > td,
  .ptable-responsive > .ptable > tfoot > tr > td {
    white-space: nowrap;
  }
  .ptable-responsive > .ptable-bordered {
    border: 0;
  }
  .ptable-responsive > .ptable-bordered > thead > tr > th:first-child,
  .ptable-responsive > .ptable-bordered > tbody > tr > th:first-child,
  .ptable-responsive > .ptable-bordered > tfoot > tr > th:first-child,
  .ptable-responsive > .ptable-bordered > thead > tr > td:first-child,
  .ptable-responsive > .ptable-bordered > tbody > tr > td:first-child,
  .ptable-responsive > .ptable-bordered > tfoot > tr > td:first-child {
    border-left: 0;
  }
  .ptable-responsive > .ptable-bordered > thead > tr > th:last-child,
  .ptable-responsive > .ptable-bordered > tbody > tr > th:last-child,
  .ptable-responsive > .ptable-bordered > tfoot > tr > th:last-child,
  .ptable-responsive > .ptable-bordered > thead > tr > td:last-child,
  .ptable-responsive > .ptable-bordered > tbody > tr > td:last-child,
  .ptable-responsive > .ptable-bordered > tfoot > tr > td:last-child {
    border-right: 0;
  }
  .ptable-responsive > .ptable-bordered > tbody > tr:last-child > th,
  .ptable-responsive > .ptable-bordered > tfoot > tr:last-child > th,
  .ptable-responsive > .ptable-bordered > tbody > tr:last-child > td,
  .ptable-responsive > .ptable-bordered > tfoot > tr:last-child > td {
    border-bottom: 0;
  }
}';
        echo "</style>\n";
        echo "</head>\n";
        // inclui a tabela no documento
        $this->table->show();
        echo "</html>";
        $content = ob_get_clean();

        file_put_contents($filename, $content);
        return TRUE;
    }
    
    public function renderize(){
    
    $this->table->add($this->thead);
        $this->table->add($this->tbody);

  
        $this->table->show();
    
     
    
    }
}

?>