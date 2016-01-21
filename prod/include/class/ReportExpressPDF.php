<?php
$ruta_raiz = "..";

include_once "$ruta_raiz/include/db/ConnectionHandler.php";

define('FPDF_FONTPATH',"$ruta_raiz/fpdf/font/");
require("$ruta_raiz/fpdf/fpdf.php");
require("$ruta_raiz/radsalida/masiva/OpenDocText.class.php");
class ReportExpressPDF extends FPDF{


    var $versionForm;
    var $dependencia;
    var $objODT;
    var $consecutivo;
    var $archivo;
    var $krd;
    var $db;
    var $radicado;
    function  __construct($db=null)
    {
        $this->db = new ConnectionHandler("..");
        $this->objODT = new OpenDocText();
    }
    
    function creaFormato($vecDepDest)
    {
        parent::__construct('L','mm', 'letter');
        $this->SetFont('Arial','B',5);
        $this->SetTitle("Formato Radicación Express");
        $this->SetAuthor("");
        $this->SetCreator("Developed by Grupo Iyunxi Ltda.");
        $this->AliasNbPages();
        $this->cuerpo($vecDepDest,$vecDepInf);
    }

    function Header()
    {
      
    }

   
    function Footer()
    {
     
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
    
    function cuerpo($depDest)
    {
        $WIMP = $this->w - (2*$this->lMargin);
        //$this->SetFillColor(200,220,255);
        $this->SetFont('Arial','B',7);        
        $evalDep=$depDest[0]['DEPDESTINO'];
        $evalRad=$depDest[0]['RADICADO'];
        $contadores=$this->contadores($depDest);
        $band=true;
        $evalDep= utf8_decode($evalDep);
        $this->dependencia=$evalDep;
        $this->AddPage(); 
        $this->Cell($WIMP,5, utf8_decode($this->Entidad),0,2,'C');
        $this->Cell($WIMP,5, utf8_decode('Sección Gestión Documental'),0,2,'C');
        $this->Cell($WIMP,5,$this->titulo,0,2,'C');
        $this->SetFont('Arial','',7);
        $this->Cell($WIMP,5,"",0,1,'C');
        $this->Cell($WIMP*0.35,5,"Dependencia",0,0,'C');$this->Cell($WIMP*0.35,5, utf8_decode("Rango de Impresión"), 0,0,'C');$this->Cell($WIMP*0.20,5, utf8_decode("Fecha de Impresión"),0,0,'C');$this->Cell($WIMP*0.10,5,"No de Registros",0,1,'C');$this->Cell($WIMP*0.10,5,"Consecutivo",0,1,'C');
        $this->Cell($WIMP*0.35,5,$this->dependencia,0,0,'C');$this->Cell($WIMP*0.35,5,"Desde:".$this->fechaIni." Hasta:".$this->fechaFin,0,0,'C');$this->Cell($WIMP*0.20,5,$this->fechaHoy,0,0,'C');$this->Cell($WIMP*0.10,5,$contadores[$this->dependencia],0,1,'C');$this->Cell($WIMP*0.10,5,str_pad($this->consecutivo,6,"0", STR_PAD_LEFT),0,1,'C');
        $this->Cell($WIMP,5,"",0,1,'C');
        $this->SetWidths(array(31,20,80,80,20,20,10)); 
        $this->SetAligns(array("C","C","C","C","C","C","C"));
        $this->Row(array("RADICADO","No. OFICIO","REMITENTE","DIGNATARIO","ANEXOS","FOL.","Cop"));

        $i=0;
        while(count($depDest)>0)
        {
	        foreach ($depDest as $a =>$valDest)
	        {
	                if($evalDep==$valDest['DEPDESTINO'])
	                {     
                               

//                                
//	                        //$this->Cell($WIMP*0.03,5,$valDest['URGENTE'],1,0);
	                        $valDest['TIPO']?$cc='X':$cc='';
	                      
                                
                                $this->Row(array($valDest['RADICADO'],$valDest['NOFICIO'],substr(iconv($this->objODT->codificacion($valDest['REMITENTE']),'ISO8859-1',$valDest['REMITENTE']),0,59),substr(iconv($this->objODT->codificacion($valDest['DIGNATARIO']),'ISO8859-1',$valDest['DIGNATARIO']),0,35),substr(iconv($this->objODT->codificacion($valInf['ANEXOS']),'ISO8859-1',$valInf['ANEXOS']),0,20),$valDest['NHOJA'],$cc));
	                        if($band)
	                        {
	                            foreach ($depDest as $b => $valInf)
	                            {
	                                if($valDest['RADICADO']!=$valInf['RADICADO'] && $evalDep==$valInf['DEPDESTINO'])
	                                {
                                              $this->Row(array($valDest['RADICADO'],$valDest['NOFICIO'],substr(iconv($this->objODT->codificacion($valDest['REMITENTE']),'ISO8859-1',$valDest['REMITENTE']),0,59),substr(iconv($this->objODT->codificacion($valDest['DIGNATARIO']),'ISO8859-1',$valDest['DIGNATARIO']),0,35),substr(iconv($this->objODT->codificacion($valInf['ANEXOS']),'ISO8859-1',$valInf['ANEXOS']),0,20),$valDest['NHOJA'],$cc));
	                                   	unset($depDest[$b]);
	                                }
	                            }
	                            $band=false;
	                        }
                                
	                        $evalRad=$valDest['RADICADO'];
                                
	                        unset($depDest[$a]);
	                }
	                else
	                {
	                    foreach ($depDest as $b => $valInf)
	                    {
	                        if($valDest['RADICADO']!=$valInf['RADICADO'] && $evalDep==$valInf['DEPDESTINO'])
	                        {   
	                            $this->Row(array($valDest['RADICADO'],$valDest['NOFICIO'],substr(iconv($this->objODT->codificacion($valDest['REMITENTE']),'ISO8859-1',$valDest['REMITENTE']),0,59),substr(iconv($this->objODT->codificacion($valDest['DIGNATARIO']),'ISO8859-1',$valDest['DIGNATARIO']),0,35),substr(iconv($this->objODT->codificacion($valInf['ANEXOS']),'ISO8859-1',$valInf['ANEXOS']),0,20),$valDest['NHOJA'],$cc));
	                            unset($depDest[$b]);
	                        }
	                    }
	                    
                            $this->SetFont('Arial','',7);
                            $this->Cell(70,20,'Observaciones:',0,1,'L');
                            $this->Cell($WIMP*0.33,5,'Fecha de Entrega:',0,0,'L');
                            $this->Cell($WIMP*0.33,5,utf8_decode('Entregá:'),0,0);
                            $this->Cell($WIMP*0.33,5,utf8_decode('Recibió:'),0,1);
	                    $this->dependencia=$valDest['DEPDESTINO'];
                            $this->AddPage();
                            $this->SetFont('Arial','B',7);
                            $this->Cell($WIMP,5,utf8_decode($this->Entidad),0,2,'C');
                            $this->Cell($WIMP,5, utf8_decode('Sección Gestión Documental'),0,2,'C');
                            $this->Cell($WIMP,5,$this->titulo,0,2,'C');
                            $this->SetFont('Arial','',7);
                            $this->Cell($WIMP,5,"",0,1,'C');
                            $this->Cell($WIMP*0.35,5,"Dependencia",0,0,'C');$this->Cell($WIMP*0.35,5,utf8_decode("Rango de Impresión"),0,0,'C');$this->Cell($WIMP*0.20,5, utf8_decode("Fecha de Impresión"),0,0,'C');$this->Cell($WIMP*0.10,5,"No de Registros",0,1,'C');
                            $this->Cell($WIMP*0.35,5,utf8_decode($this->dependencia),0,0,'C');$this->Cell($WIMP*0.35,5,"Desde:".$this->fechaIni." Hasta:".$this->fechaFin,0,0,'C');$this->Cell($WIMP*0.20,5,$this->fechaHoy,0,0,'C');$this->Cell($WIMP*0.10,5,$contadores[$this->dependencia],0,1,'C');
                            $this->Cell($WIMP,5,"",0,1,'C');
                            $this->SetWidths(array(31,20,80,80,20,20,10)); 
                            $this->SetAligns(array("C","C","C","C","C","C","C"));
                            $this->Row(array("RADICADO","No. OFICIO","REMITENTE","DIGNATARIO","ANEXOS","FOL.","Cop"));
                            $this->Row(array($valDest['RADICADO'],$valDest['NOFICIO'],substr(iconv($this->objODT->codificacion($valDest['REMITENTE']),'ISO8859-1',$valDest['REMITENTE']),0,59),substr(iconv($this->objODT->codificacion($valDest['DIGNATARIO']),'ISO8859-1',$valDest['DIGNATARIO']),0,35),substr(iconv($this->objODT->codificacion($valInf['ANEXOS']),'ISO8859-1',$valInf['ANEXOS']),0,20),$valDest['NHOJA'],$cc));

                            $evalRad=$valDest['RADICADO'];
                            $band=true;
                           
                            unset($depDest[$a]);
	                }
                       
                        $this->radicado[$i] = $valDest['RADICADO'];
	               $evalDep=$valDest['DEPDESTINO'];
	               break;
	        }
                $i++;
        }
        
        
        
        
        
        $this->SetFont('Arial','',7);
        $this->Cell(70,20,'Observaciones:',0,1,'L');
        $this->Cell($WIMP*0.33,5,'Fecha de Entrega:',0,0,'L');
        $this->Cell($WIMP*0.33,5,utf8_decode('Entrega:'),0,0);
        $this->Cell($WIMP*0.33,5,utf8_decode('Recibido:'),0,1);
    }

    function enlacePDF($i=0)
    {
    	include("../config.php");
        $band = true;
        $this->archivo = "/tmp/RepExp".date('YmdHis')."$i.pdf";
       $this->insertarCosecutivo();
       ($this->Output("../".$carpetaBodega.$this->archivo) == '') ? $band = "../seguridadImagen.php?fec=".base64_encode($this->archivo) : $band = false;
       return $band;
    }
    
    function insertarCosecutivo()
    {
         
        $datos = array();
                $datos['FECHAINI']=$this->db->conn->DBTimeStamp($this->fechaIni);
                $datos['FECHAFIN'] =  $this->db->conn->DBTimeStamp($this->fechaFin);
                $datos['LOGIN'] = "'".$this->krd."'";
                $datos['RUTA'] = "'".$this->archivo."'";
                $datos['CONSECUTIVO'] = $this->consecutivo;
                
                $this->db->insert("CONSECUTIVOPLANILLA",$datos);
                
    }
    function contadores($arreglo)
    {		
    	$count=null;
    	foreach ($arreglo as $i=>$val)
    	{
    		$cont[$val['DEPDESTINO']]=$cont[$val['DEPDESTINO']]+1;
    	}
    	return $cont;
    }
}
?>
