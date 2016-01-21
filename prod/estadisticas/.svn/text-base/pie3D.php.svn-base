
<?php
$rutaJpGraph = "../jpgraph/src";
error_reporting(1);
include ("$rutaJpGraph/jpgraph_pie.php");
include ("$rutaJpGraph/jpgraph_pie3d.php");
$data = array(1);
$graph = new PieGraph(490,300,"auto");
$graph->img->SetAntiAliasing();
$graph->SetMarginColor('white');

$graph->legend->Pos(0.75,0.2);
// Setup margin and titles
$graph->title->SetFont(FF_FONT2,FS_NORMAL1,5);
$graph->title->Set("INFORME PQR ");
$p1 = new PiePlot3D($data1y);//$_GET['datoss'][0]);
$p1->SetSize(0.35);
$p1->SetLabelMargin(5);
$p1->SetAngle(65);
$p1->SetCenter(0.52,0.6);
$p1->ExplodeSlice(3);
// Setup slice labels and move them into the plot
//$p1->SetLabelType(PIE_VALUE_ABS);
$p1->value->SetFont(FF_FONT1,FS_BOLD,5);
$p1->value->SetColor("black");
$p1->SetLabelPos(0.6);
$p1->SetLabels($nombPqrLbl,0.2);
$p1->SetLegends($nombPqr);//$_GET['nombres'][0]);
$graph->Add($p1);
$graph->Stroke($rutaImagen);

?>