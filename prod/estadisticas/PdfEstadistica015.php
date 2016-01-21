<?php
define('FPDF_FONTPATH','../fpdf/font/');
require('../fpdf/html_table.php');
$rutaJpGraph = "../jpgraph/src";
include ("$rutaJpGraph/jpgraph.php");
include ("$rutaJpGraph/jpgraph_bar.php");
include ("$rutaJpGraph/jpgraph_line.php");
session_start();
class PdfEstadistica015 extends PDF
{

var $rutaimg ;
function Header()
{
    $this->SetFont('Arial','B',14);
    $this->Image("./img/logo_entidad.png", 10,10,30,30);
    $this->Image("./img/bicentenario.png", 155,13,50,30);
    $this->Cell(60,15,"",0,1,'L');
    $this->Cell(60,15,"",0,0,'L');
	$this->Cell(65,5,"INFORME DE GESTION - PQR ",0,2,'C');
    
}

function Footer()
{
 
    
    $this->SetY(-15);
    
    $this->SetFont('Arial','I',7);
    $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
}

}

$pdf = new PdfEstadistica015("P","mm","Letter");
$pdf->SetFont('Arial','',7);
$pdf->rutaimg=$rutaImagen;
$pdf->AddPage();


$WIMP = $pdf->w-(2*$pdf->lMargin)- 50;

if($dependencia_busq==99999)
{   $pdf->SetFont('Arial','B',10);
    $pdf->Cell(65,5,"Todas las Dependencias",0,1,'C');
    $pdf->Cell(30,135,"",0,1,'L');
    $sql=$selectE.$query.$group." order by 1";
    $rs=$db->query($sql);
    //echo $sql;
    $grupoPlot=array();
    $i=0;
    $depAux[0]=$rs->fields[0];
    while(!$rs->EOF)
    {
        if($depAux[$i]!=$rs->fields[0])
        {
            $i++;
            $depAux[$i]=$rs->fields[0];

        }
        $dep[$i][$rs->fields[2]]=$rs->fields[1];
        $pqrAux[$rs->fields[2]]=1;
        $rs->MoveNext();
    }
    $cnt=$WIMP/(count($pqrAux)+1);
    $pdf->SetFont('Arial','B',10);
    //$pdf->Cell(90,5,"desde:$fecha_ini hasta:$fecha_fin",1,1,'C');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50,5,"Dependencia",1,0,'C');
    $vecColor=array(0=>"orange",1=>"chartreuse3",2=>"burlywood",3=>"yellow",
                    4=>"thistle2",5=>"dodgerblue",6=>"mintcream",6=>"salmon",7=>"thistle",8=>"slategray",9=>"cadetblue3",10=>"bisque4",
                    11=>"darkseagreen",12=>"palegreen2",13=>"peachpuff4",14=>"peru",15=>"purple",16=>"sienna3",17=>"tan2",
                    18=>"yellow4",19=>"tomato2",20=>"tan");
    foreach($pqrAux as $i=> $val)
    {
        $pdf->Cell($cnt,5,$i,1,0,'C');
        $vecPqrAux[]=$i;
    }
    $pdf->Cell($cnt,5,"Total",1,1,'C');
    $total=0;
    $totalGral=0;
    $band=false;
    $nombUs=null;
    $pdf->SetFont('Arial','',5);
    $odt = new OpenDocText();
    foreach($dep as $i=> $val1)
    {
        $pdf->Cell(50,5,iconv($odt->codificacion($depAux[$i]),"ISO-8859-1",$depAux[$i]),1,0,'L');
        $nombUs[]=iconv($odt->codificacion($depAux[$i]),"ISO-8859-1",$depAux[$i]);
        for($l=0;$l<count($vecPqrAux);$l++)
        {   foreach($val1 as $k =>$val2)
            {
                 if($vecPqrAux[$l]==$k)
                 {
                     $pdf->Cell($cnt,5,$val2,1,0,'C');
                     $total=$total+$val2;
                     $band=true;
                     break;
                 }else $band=false;
        
            }
            if($band==false)
            {
                
                $pdf->Cell($cnt,5,"",1,0,'L');
            }
        }
        $pdf->Cell($cnt,5,$total,1,1,'C');
        $totalGral=$totalGral+$total;
        $total=0;
    }
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(50,5,"TOTAL GENERAL",1,0,'L');
    $band=false;
    $totalPqr=0;
    foreach($vecPqrAux as $i =>$pqr)
    {
        foreach($dep as $j=> $val1 )
        {
            foreach($val1 as $p =>$val2)
            {
                if($p==$pqr)
                {
                    ${"datoyy".$i}[]=$val2;
                    $totalPqr=$totalPqr+$val2;
                    $band=true;
                    break;
                }
                else $band=false;
            }
            if($band==false)
            {
                ${"datoyy".$i}[]=0;
                
            }
        }
        $pdf->Cell($cnt,5,$totalPqr,1,0,'C');
        $totalPqr=0;
        $vecGroupPlot[$i]= new BarPlot(${"datoyy".$i});
        $vecGroupPlot[$i]->SetFillColor($vecColor[$i]);
        $vecGroupPlot[$i]->SetLegend($pqr);
        $vecGroupPlot[$i]->value->Show(true);
        $vecGroupPlot[$i]->value->SetFormat("%02d ");
        //$vecGroupPlot[$i]->value->SetColor("blue","black");
        $vecGroupPlot[$i]->value->SetFont(FF_ARIAL,FS_NORMAL,5);
    }
    $pdf->Cell($cnt,5,$totalGral,1,1,'C');
    include "genBarras2.php";
    $pdf->Image($pdf->rutaimg, 40,50,135,95);
}
else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(65,5,$nombUs[0],0,1,'C');
    $pdf->Cell(30,50,"",0,1,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60,5,"Fechas  Entre:$fecha_ini y $fecha_fin",0,1,'C');
    $pdf->Cell(30,5,"",0,1,'L');
    $pdf->Cell(25,5,"PQR",1,0,'C');
    $pdf->Cell(22,5,"CANTIDAD",1,0,'C');
    $pdf->Cell(15,5," % ",1,1,'C');
    $pdf->SetFont('Arial','',10);
    $total=0;
    foreach ($nombPqr as $i=>$val)
    {
        $total=$total+$data1y[$i];
    }
    $sumPctj=0;

    foreach ($nombPqr as $i=>$val)
    {
        $pdf->Cell(25,5,$val,1,0,'L');
        $pdf->Cell(22,5,$data1y[$i],1,0,'C');
        $pctj=number_format(($data1y[$i]/$total)*100,1,".","");
        $sumPctj=$sumPctj+$pctj;
        $pdf->Cell(15,5,$pctj."%",1,1,'C');
    }
    $pdf->Cell(25,5,"TOTAL",1,0,'L');
    $pdf->Cell(22,5,$total,1,0,'C');
    $pdf->Cell(15,5,$sumPctj."%",1,0,'C');
    include "pie3D.php";
    $pdf->Image($pdf->rutaimg, 75,70,120,80);
}
$dbTmp=$db;
include_once '../config.php';
$db=$dbTmp;
$arch="/tmp/E_$krd.pdf";
$arpdf_tmp = $ruta_raiz.$carpetaBodega.$arch


$pdf->Output($arpdf_tmp,'F');
$l="<a href=$ruta_raiz/seguridadImagen.php?fec=".base64_encode($arch)." target=".date("dmYh").time("his")."><img  width='30' height='13' src='../imagenes/pdf.png' border='0' alt='Formato PDF' title='Formato PDF' align='top' /></a></b></center>";
?>
<table BORDER=0 WIDTH=100% class="titulos2">
<tr>
	<td class="listado2" align="center">
		<center><b>Reporte PDF Imprimir. </b><br><?echo $l?></center>
	</td>
</tr>
</table>
