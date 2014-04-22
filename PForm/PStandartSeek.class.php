<?php

/**
 * PStandartSeek  TWindow
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @subpackage PForm
 * @author     Alexandre E. Souza
 */
class PStandartSeek extends TWindow
{
    private $form;      // form
    private $datagrid;  // datagrid
    private $pageNavigation;

    protected $loaded;
    
    /**
     *
     * @param String $p
     * @see prefix para os campos de retorno 
     * @example cliente_id
     */
    public function setPrefix($p){
    	 
    
    
    	TSession::setValue('prefix', $p);
    	 
    }
    
    
    
 
  /**
   * 
   * @param String $f
   * @see formulario para onde os dados seram enviados
   */  
  public function setParentForm($f){
  	
  
  		
  		TSession::setValue('parent', $f);
  	
  }
  
  /**
   *
   * @param String $k
   * @see chave que sera retornada
   */
  public function setKey($k){
  	 
  
  
  		TSession::setValue('key', $k);
  	
  }
  
  /**
   * 
   * @return String
   */
  
  public function  getParentForm(){
  	
  	TSession::getValue('parent');
  }
  
  
  
  /**
   *
   * @param Array $c
   * @see campos que seram mostrados
   */
  public function setCampos( $c){
  	 
  	if(is_array($c)){
  	
  
  		TSession::setValue('campos',$c);
  	
  }else{
  	
  	throw new Exception('Variavel n�o � um array');
   }
  }
  
  /**
   *
   * @return Array de campos
   */
  
  public function  getCampos(){
  	 
  	return  TSession::getValue('campos');
  }
  
  /**
   *
   * @param String $m
   * @see Model a ser utilizada
   */
  public function setModel($m){
  	 
  	
  
  		TSession::setValue('model',$m);
  	
  }
  
  /**
   *
   * @return String
   */
  
  public function  getModel(){
  	 
  	return  TSession::getValue('model');
  }
  
  
  /**
   *
   * @param String $b
   * @see Banco a ser utilizado
   */
  public function setBanco($b){
  
  	
  
  		TSession::setValue('banco',$b);
  	
  }
  
  /**
   *
   * @return String
   */
  
  public function  getBanco(){
  
  	return  TSession::getValue('banco');
  }
  

  
  /**
   *
   * @param String $filtro
   * @seefiltro a ser usado na busca
   */
  public function setFiltro($filtro){
  
  	
  
  		TSession::setValue('filtro', $filtro);
  	
  }
  
  /**
   *
   * @param String $filtro
   * @seefiltro a ser usado na busca
   */
  public function setWidth($width){
  
  	 
  
  	TSession::setValue('width', $width);
  	 
  }
  
  /**
   *
   * @param String $filtro
   * @seefiltro a ser usado na busca
   */
  public function setHeight($height){
  
  	 
  
  	TSession::setValue('height', $height);
  	 
  }
  
  /**
   *
   * @param String $filtro
   * @seefiltro a ser usado na busca
   */
  public function setTitulo($titulo){
  
  	 
  
  	TSession::setValue('titulo', $titulo);
  	 
  }
  
  /**
   *
   * @return String
   */
  
  public function  getFiltro(){
  
  	return  TSession::getValue('filtro');
  }
    
    /**
     * constructor method
     */
    public function __construct()
    {
        parent::__construct();
     
      parent::setSize(TSession::getValue('width'),TSession::getValue('height'));
      parent::setTitle(TSession::getValue('titulo'));
     
         
        new TSession;
        
     
        // creates the form
        $this->form = new TForm('formSeekStandart');
        // creates the table
        $table = new TTable;
        
        // add the table inside the form
        $this->form->add($table);
        
        // create the form fields
        $name= new TEntry('name');
        // keep the session value
        $name->setValue(TSession::getValue('name'));
        
        // add the field inside the table
        $row=$table->addRow();
        $row->addCell(new TLabel($this->getFiltro().' :'));
        $row->addCell($name);
        
        // create a find button
        $find_button = new TButton('search');
        // define the button action
        $find_button->setAction(new TAction(array($this, 'onSearch')), 'Search');
        $find_button->setImage('ico_find.png');
        
        // add a row for the find button
        $row=$table->addRow();
        $row->addCell($find_button);
        
        // define wich are the form fields
        $this->form->setFields(array($name, $find_button));
        
        // create the datagrid
        $this->datagrid = new TDataGrid;
        
        $i=1;
        // create the datagrid columns
        
     
       if(TSession::getValue('campos')){
       foreach (TSession::getValue('campos') as $field => $label){
       
       	$campos[] = new TDataGridColumn($field,   $label,   'right',200);
       }
    
        foreach ($campos as $campo){
        
           // add the columns inside the datagrid
        $this->datagrid->addColumn($campo);
    }
    
   
     }
        
    
        
        // create one datagrid action
        $action1 = new TDataGridAction(array($this, 'onSelect'));
        $action1->setLabel('Selecionar');
        $action1->setImage('ico_apply.png');
        $action1->setField(TSession::getValue('key'));
        
        // add the action to the datagrid
        $this->datagrid->addAction($action1);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigator
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // create a table for layout
        $table = new TTable;
        // create a row for the form
        $row = $table->addRow();
        $row->addCell($this->form);
        
        // create a row for the datagrid
        $row = $table->addRow();
        $row->addCell($this->datagrid);
        
        // create a row for the page navigator
        $row = $table->addRow();
        $row->addCell($this->pageNavigation);
        
        // add the table inside the page
        parent::add($table);
        }
    
    /**
     * Register a filter in the session
     */
    function onSearch()
    {
        // get the form data
        $data = $this->form->getData();
        
        // check if the user has filled the fields
        if (isset($data->name))
        {
            // cria um filtro pelo conteúdo digitado
            $filter = new TFilter(TSession::getValue('filtro'), 'like', "%{$data->name}%");
            
            // armazena o filtro na seção
            TSession::setValue('filter', $filter);
            TSession::setValue('name', $data->name);
            
            // put the data back to the form
            $this->form->setData($data);
        }
        
        // redefine the parameters for reload method
        $param=array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
    }
    
    /**
     * Load the datagrid with the database objects
     */
    function onReload($param = NULL)
    {
  
    	
    	
    	
 
        try
        {
         
            TTransaction::open($this->getBanco());
            
            // create a repository for City table
            $repository = new TRepository($this->getModel());
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            
            if (TSession::getValue('filter'))
            {
                // filter by city name
                $criteria->add(TSession::getValue('filter'));
            }
            
            // load the objects according to the criteria
            $data = $repository->load($criteria);
            $this->datagrid->clear();
            if ($data)
            {
                foreach ($data as $dados)
                {
                    // add the objects inside the datagrid
                    $this->datagrid->addItem($dados);
                }
            }
            
            // clear the criteria
            $criteria->resetProperties();
            $count= $repository->count($criteria);
            
            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit
            
         
            $this->loaded = TRUE;
        }
        catch (Exception $e) // exceptions
        {
            // show the error message
            new TMessage('error','<b>Erro</b> ' . $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
     
   
    }
    
  
    
    /**
     * Executed when the user chooses the record
     */
    function onSelect($param)
    {
    
    	
    
    	
    	$key = $param['key'];
    	
    	
    	
    	$prefix = TSession::getValue('prefix');
        try
        {
           
           $model = isset($param['model']) ? $param['model'] : TSession::getValue('model');
          
           
             TTransaction::open(TSession::getValue('banco'));
            // load the active record
            $campos = new $model($key);
            

            
         $cliente = new stdClass();
         
            foreach (TSession::getValue('campos') as $field => $label){
            	
             $cliente->{$prefix.'_'.$field} = $campos->{$field};
            }
            
        
          
            TForm::sendData(TSession::getValue('parent'),  $cliente );
            parent::closeWindow(); // closes the window
        }
        catch (Exception $e) // em caso de exceção
        {
            throw new Exception('Erro com a mensagem '.$e->getMesage());
            
            // undo pending operations
            TTransaction::rollback();
        }
        
       parent::closeWindow();
    }
    
    /**
     * Shows the page
     */
    function show()
    {
        // if the datagrid was not loaded yet
        if (!$this->loaded)
        {
            $this->onReload();
        }
        parent::show();
    }
}

?>