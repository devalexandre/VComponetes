<?php


class PNoteBook extends TElement{

 protected $elements;
    protected $ul;
    protected  $content;
 protected $page_active;

    public function __construct($width,$heigth)
    {
        parent::__construct('div');


        $this->id = 'tabs'.uniqid();

$width1 = $width + 10;
$heigth1 = $heigth +20;

        $this->ul = new TElement('ul');
        $this->ul->id = 'pnotebook'.uniqid();
        
        $this->ul->class="tabs";
        $this->style= "width :{$width1}px;heigth :{$heigth1}px;";
        
$this->ul->style= "width : {$width}px;heigth :{$heigth}px";



        $this->elements = array();
        $this->content = new TElement('div');

    }
    

    public function appendPage($title, $object)
    {
        $this->elements[$title] = $object;
    }




    public function show()
    {


        foreach($this->elements as $item => $value ):

            $li = new TElement('li');

        $a = new TElement('a');
          $a->href="#{$item}";

$a->add($item);
$li->add($a);


            $this->ul->add($li);
            endforeach;




        parent::add($this->ul);


        foreach($this->elements as $item => $value ):



            $conteudo = new TElement('div');

            $conteudo->id = $item;
            $conteudo->add($value);

            parent::add($conteudo);

        endforeach;


        $script = new TElement('script');
        $script->type = 'text/javascript';
        $code = "  $(function() {
$( '#{$this->id}' ).tabs();
});";
        $script->add($code);
        parent::add($script);


        parent::show();
    }

}

?>