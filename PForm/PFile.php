<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 8/21/14
 * Time: 9:33 AM
 */

class PFile extends TField implements IWidget{
    protected $height;
    protected $folder;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->height = 25;
    }

    public function setFolder($folder){
        $this->folder = $folder;
    }
    public function setSize($width, $height = NULL)
    {
        $this->size   = $width;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Show the widget at the screen
     */
    public function show()
    {

        TPage::include_js('lib/adianti/include/tfile/tfile.js');

        // define the tag properties
        $this->tag-> id    = $this->name . '_' . uniqid();
        $this->tag-> name  = 'file_' . $this->name;  // tag name
        $this->tag-> value = $this->value; // tag value
        $this->tag-> type  = 'file';       // input type
        $this->tag-> style = "width:{$this->size}px;height:{$this->height}px";  // size

        $hdFileName = new THidden($this->name);
        $hdFileName->setValue( $this->value );

        // verify if the widget is editable
        if (!parent::getEditable())
        {
            // make the field read-only
            $this->tag-> readonly = "1";
            $this->tag-> type = 'text';
            $this->tag->{'class'} = 'tfield_disabled'; // CSS
        }

        $div = new TElement('div');
        $div-> style="display:inline;width:100%;";
        $div-> id = 'div_file_'.uniqid();

        $div->add( $hdFileName );
        $div->add( $this->tag );
        $div->show();

        $script = new TElement('script');
        $script->{'type'} = 'text/javascript';
        $action = 'engine.php?class=PUploadFiles&dir='.$this->folder;
        $script->add("
            $(document).ready( function()
            {
                $('#{$this->tag->id}').change( function()
                {
                    var tfile = new TFileAjaxUpload('{$this->tag->id}','{$action}','{$div->id}');

                    tfile.initFileAjaxUpload();
                });
            });");
        $script->show();
    }

    /**
     * Enable the field
     * @param $form_name Form name
     * @param $field Field name
     */
    public static function enableField($form_name, $field)
    {
        $script = new TElement('script');
        $script->{'language'} = 'JavaScript';
        $script->setUseSingleQuotes(TRUE);
        $script->setUseLineBreaks(FALSE);
        $script->add( " try { document.{$form_name}.file_{$field}.removeAttribute('disabled'); } catch (e) { } " );
        $script->add( " try { document.{$form_name}.file_{$field}.className = 'tfield'; } catch (e) { } " );
        $script->show();
    }

    /**
     * Disable the field
     * @param $form_name Form name
     * @param $field Field name
     */
    public static function disableField($form_name, $field)
    {
        $script = new TElement('script');
        $script->{'language'} = 'JavaScript';
        $script->setUseSingleQuotes(TRUE);
        $script->setUseLineBreaks(FALSE);
        $script->add( " try { document.{$form_name}.file_{$field}.setAttribute('disabled', true); } catch (e) { } " );
        $script->add( " try { document.{$form_name}.file_{$field}.className = 'tfield_disabled'; } catch (e) { } " );
        $script->show();
    }

    /**
     * Clear the field
     * @param $form_name Form name
     * @param $field Field name
     */
    public static function clearField($form_name, $field)
    {
        $script = new TElement('script');
        $script->{'language'} = 'JavaScript';
        $script->setUseSingleQuotes(TRUE);
        $script->setUseLineBreaks(FALSE);
        $script->add( " try {
                                var parentDiv = document.{$form_name}.{$field}.parentNode;
                                if( parentDiv.firstChild.tagName == 'IMG' )
                                {
                                    parentDiv.firstChild.remove();
                                }
                            } catch (e) { } "
        );
        $script->add( " try { document.{$form_name}.{$field}.value='' } catch (e) { } " );
        $script->add( " try { document.{$form_name}.file_{$field}.value='' } catch (e) { } " );
        $script->show();
    }
}