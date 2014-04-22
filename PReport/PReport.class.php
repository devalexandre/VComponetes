
<?php

/**
 * PReport TTableWriterPDF
 *
 * @version    1.0
 * @version adianti framework 1.0.2
 * @package    widget_web
 * @author     Alexandre E. Souza
 
 */

class PReport extends TTableWriterPDF{


private $logo;
private $title;
private $pdf;

    public function __construct($widths){

        parent::__construct($widths);

        $this->pdf = parent::getNativeWriter();
        
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


 public function header(){

     // Logo
     $this->pdf->Image($this->logo,10,8,100,130);
     // Arial bold 15
     $this->pdf->SetFont('Arial','B',15);
     // Move to the right
     $this->pdf->Cell(80);
     // Title
     $this->pdf->Cell(30,10,$this->title,1,0,'C');

     $this->pdf->SetY(0);

     $this->pdf->Ln(120);

 }

    public function img($img,$width = 100,$heigth = 140){

        $this->pdf->Image($img,10,10,$width,$heigth);
    }
}