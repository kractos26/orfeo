<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reporteenviopdf
 *
 * @author Julian Andres Ortiz Moreno
 */
    // Logo
$ruta_raiz = "..";

require("$ruta_raiz/auxLib/fpdf16/fpdf.php");
require_once("$ruta_raiz/radsalida/masiva/OpenDocText.class.php");
define('FPDF_FONTPATH', "$ruta_raiz/fpdf/font/");
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	
define('ADODB_FETCH_ASSOC',2);$
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
class PDF extends FPDF
{
    var $widths;
    var $contenido;
    var $aligns;
    var $fecha_busq;
    var $fecha_busq2;
    var $consecutivo;
    var $sql;
    var $db;
    
// Cabecera de página
function Header()
{
        include("../config.php");
         $this->SetFont('Arial', '', 10);
         $this->MultiCell(280, 6, $entidad, 1);
         $this->SetXY(10, 16);
         $this->MultiCell(280, 6, 'REPORTE DE DOCUMENTOS ELAVORADO ENTRE  '.$this->fecha_busq.' Y '.$this->fecha_busq2, 1);
         $this->SetXY(10, 22);
}

function __construct($ruta_raiz) {
   
        $db = new ConnectionHandler($ruta_raiz);
        $this->db = $db;
        
        //$this->objODT = new OpenDocText();
    }

function SetWidths($w)
{
   //Set the array of column widths
   $this->widths=$w;
}

function SetAligns($a)
{
   //Set the array of column alignments 
   $this->aligns=$a;
}

function fill($f)
{
//juego de arreglos de relleno
   $this->fill=$f;
}

function Row($data) 
{ 
    //Calculate the height of the row 
    $nb=0; 
    for($i=0;$i<count($data);$i++) 
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
    $h=5*$nb; 
    //Issue a page break first if needed 
    $this->CheckPageBreak($h); 
    //Draw the cells of the row 
    for($i=0;$i<count($data);$i++) 
    { 
        $w=$this->widths[$i]; 
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L'; 
        //Save the current position 
        $x=$this->GetX(); 
        $y=$this->GetY(); 
        //Draw the border 
        $this->Rect($x,$y,$w,$h); 
        //Print the text 
        $this->MultiCell($w,5,$data[$i],0,$a); 
        //Put the position to the right of the cell 
        $this->SetXY($x+$w,$y); 
    } 
    //Go to the next line 
    $this->Ln($h); 
} 

function CheckPageBreak($h)
{

//If the height h would cause an overflow, add a new page immediately

    if($this->GetY()+$h>$this->PageBreakTrigger)

    $this->AddPage($this->CurOrientation);

}

function NbLines($w,$txt) 
{ 
    //Computes the number of lines a MultiCell of width w will take 
    $cw=&$this->CurrentFont['cw']; 
    if($w==0) 
        $w=$this->w-$this->rMargin-$this->x; 
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
    $s=str_replace("\r",'',$txt); 
    $nb=strlen($s); 
    if($nb>0 and $s[$nb-1]=="\n") 
        $nb--; 
    $sep=-1; 
    $i=0; 
    $j=0; 
    $l=0; 
    $nl=1; 
    while($i<$nb) 
    { 
        $c=$s[$i]; 
        if($c=="\n") 
        { 
            $i++; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
            continue; 
        } 
        if($c==' ') 
            $sep=$i; 
        $l+=$cw[$c]; 
        if($l>$wmax) 
        { 
            if($sep==-1) 
            { 
                if($i==$j) 
                    $i++; 
            } 
            else 
                $i=$sep+1; 
            $sep=-1; 
            $j=$i; 
            $l=0; 
            $nl++; 
        } 
        else 
            $i++; 
    } 
    return $nl; 
} 


 function creaHoja() 
{
       
        parent::__construct('L', 'mm', 'A4');
       
        $this->SetFont('Arial', '', 9);
        $this->SetMargins(10, 10, 2);
        $this->AddPage();
        $this->SetTitle("Radicados de documentos");
        $this->SetAuthor("JO");
        $this->SetCreator("Julian Andres Ortiz Moreno.");
        $this->AliasNbPages();
        $this->cuerpo();
 }
 
 function cuerpo()
 {  
    $rs = $this->db->conn->Execute($this->sql); 
  
     
    $this->SetWidths(array(30.1,31.1,31.1,31.1,31.1,31.1,31.1,31.1,32)); 
    $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));
    $this->Row(array("DEPENDENCIA","RADICADO","DESTINATARIO","DIRECCION","MUNICIPIO","DEPARTAMENTO","FECHA DE ENVIO","FORMA DE ENVIO","NÚMERO DE GUIA")); 
    $this->SetAligns(array("L","L","L","L","L","L","L","L","L"));
    
    while(!$rs->EOF)
    {         
                 $this->Row(array(substr($rs->fields['DEPE_NOMB'],0,29),
                     $rs->fields["RADICAR"],
                     substr($rs->fields["SGD_RENV_NOMBRE"],0,17)
                      ,$rs->fields["SGD_RENV_DIR"]
                    ,$rs->fields["SGD_RENV_MPIO"],$rs->fields["SGD_RENV_DEPTO"],
                     $rs->fields["SGD_RENV_FECH"],substr($rs->fields["SGD_FENV_DESCRIP"],0,16),
                     $rs->fields["SGD_RENV_PLANILLA"])); 
                 $rs->MoveNext();
                                
    }
    

 }

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

             

// Creación del objeto de la clase heredada

?>



