<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/30/14
 * Time: 3:26 AM
 */

class PForm extends TForm{



    public function __construct($name = 'my_form'){
        parent::__construct($name);

    }

    public function show()
    {

        TPage::include_css('app/lib/PComponetes/util/css/bootstrap.css');



        // define form properties
        $this->element-> enctype = "multipart/form-data";
        $this->element-> name    = $this->name; // form name
        $this->element-> id      = $this->name; // form id
        $this->element-> method  = 'post';      // transfer method

        // add the container to the form
        if (isset($this->child))
        {

            if($this->child instanceof TField){

                $div = new TElement('div');

                $div->{'class'} = 'form-group';
            $div->add($this->child);

            $this->element->add($div);
            }else{

                $this->element->add($this->child);
            }
        }
        // show the form
        $this->element->show();
    }


} 