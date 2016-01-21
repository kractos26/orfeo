<?php
// A medium complex example of JpGraph
// Note: You can create a graph in far fewwr lines of code if you are
// willing to go with the defaults. This is an illustrative example of
// some of the capabilities of JpGraph.

$rutaJpGraph = "../jpgraph/src";
error_reporting(7);

// Create the graph. These two calls are always required
$graph = new Graph(655,655,"auto");
//$graph->SetAngle(90);
$graph->SetScale("textlin");
$graph->title->Set($tituloGraph);
$graph->title->SetFont(FF_FONT2,FS_BOLD);
$graph->subtitle->Set(" Reporte desde:$fecha_ini hasta:$fecha_fin");
$graph->legend->Pos(0.01,0.1,"right","center");
$graph->legend->SetFont(FF_FONT1,FS_BOLD,10);
$graph->SetShadow();
$graph->img->SetMargin(100,98,120,240);
//$graph->legend->Pos(0.25,0.82);
//$graph->xaxis->SetTitle($nombXAxis );
$graph->xaxis->SetTitleSide(SIDE_BOTTOM);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetAngle(0);

$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);
$graph->xaxis->SetLabelAngle(58);
$graph->xaxis->SetTickLabels($nombUs);

$graph->yaxis->SetTitle($nombYAxis,'center');
$graph->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
$graph->yaxis->title->SetAngle(90);

/**
 * para agrupar por dependencia la cantidad de pqr's
 */

$gbplot = new AccBarPlot($vecGroupPlot);

// ...and add it to the graPH
$graph->Add($gbplot);


// Display the graph
$graph->Stroke($nombreGraficaTmp);

?>





