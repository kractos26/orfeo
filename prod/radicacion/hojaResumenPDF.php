<?php

/** Formato pdf Hoja de resumen
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.3
 * @author Grupo Iyunxi Ltda.
 *
 */
$ruta_raiz = "..";
require("$ruta_raiz/auxLib/fpdf16/fpdf.php");
require_once("$ruta_raiz/radsalida/masiva/OpenDocText.class.php");
define('FPDF_FONTPATH', "$ruta_raiz/fpdf/font/");

class HojaResumenPDF extends FPDF {

    private $db;
    private $radicado;
    private $fileBar;

    function __construct($db = null) {
        $this->db = $db;
        $this->objODT = new OpenDocText();
    }

    function creaHoja($radicado) {
        $this->radicado = $radicado;
        parent::__construct('P', 'mm', 'Letter');
        $this->barCode();
        $this->SetFont('Arial', 'B', 5);
        $this->SetMargins(20, 10, 2);
        $this->AddPage();
        $this->SetTitle("Hoja Resumen Radicado");
        $this->SetAuthor("IYU");
        $this->SetCreator("Developed by Grupo Iyunxi Ltda.");
        $this->AliasNbPages();
        $this->cuerpo($radicado);
    }

    function Header() {
        include("../config.php");
        $this->Image('../logoEntidad.gif', 21, 11, 40);
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 9, '', 0, 0, 'C');
        $this->Cell(50, 9, $this->ChC($entidad_largo), 0, 2, 'C');
        $this->SetFont('Arial', '', 10);
        $this->SetXY($this->GetX() + 65, $this->GetY() + 14);
        $this->Image($this->fileBar, 140, 21, 60, 15);
        $this->MultiCell(60, 6, 'Radicado No: ' . $this->radicado, 0);
        $this->SetFont('Arial', '', 8);
    }

    /**
     * Pie de p?gina del reporte.
     */
    function Footer() {
        include("../config.php");
        //Posicion: a 1,5 cm del final
        $this->SetY(-50);
        //Arial italic 8
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(70, 3, 'FIRMA USUARIO:_____________________________', 0, 0, 'L');
        //$this->Cell(25,3,'',0,0,'L');
        $this->Cell(70, 3, 'FIRMA FUNCIONARIO ' . $this->ChC($entidad) . ':_____________________________', 0, 0, 'L');
        //Numero de p?gina
        $this->SetY(-15);
        $this->SetX($this->GetX() + 70);
        $this->Cell(10, 10, 'PAG.' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function cuerpo($numrad) {
        $WIMP = $this->w - (2 * $this->lMargin);
        try {
            $isql = "select trd.*,r.*,i.radi_nume_radi as informado,dir.*,ui.usua_nomb as usuarioinf,u.usua_nomb as usuariodest,di.depe_nomb as depinf,d.depe_nomb as dep,mtrd.*,ui.usua_codi as usuacodiinf,
							ser.sgd_srd_descrip,sbser.sgd_sbrd_descrip,tpdoc.sgd_tpr_descrip,tpdoc.sgd_tpr_termino
					 FROM radicado r
					 left join informados i on i.radi_nume_radi=r.radi_nume_radi and r.radi_depe_radi<>i.depe_codi
					 left join sgd_dir_drecciones dir on dir.radi_nume_radi=r.radi_nume_radi
					 left join usuario ui on ui.usua_codi=i.usua_codi and ui.depe_codi=i.depe_codi and ui.usua_codi=1
					 join usuario u  on u.usua_codi=1 and u.depe_codi=r.radi_depe_radi
					 left join dependencia di on di.depe_codi=ui.depe_codi
					 join dependencia d on d.depe_codi=u.depe_codi
					 left join sgd_rdf_retdocf trd on trd.radi_nume_radi=r.radi_nume_radi
					 left join sgd_mrd_matrird mtrd on trd.sgd_mrd_codigo = mtrd.sgd_mrd_codigo
					 left join sgd_srd_seriesrd ser on ser.sgd_srd_codigo = mtrd.sgd_srd_codigo
					 left join sgd_sbrd_subserierd sbser on sbser.sgd_srd_codigo = mtrd.sgd_srd_codigo AND sbser.sgd_sbrd_codigo = mtrd.sgd_sbrd_codigo
					 left join sgd_tpr_tpdcumento tpdoc on tpdoc.sgd_tpr_codigo = mtrd.sgd_tpr_codigo
					 WHERE r.radi_nume_radi = $numrad ";
            //$this->db->conn->debug=true;
            $rs = $this->db->conn->Execute($isql);
            if ($rs && !$rs->EOF) {
                $i = 0;
                if ($rs->fields["SGD_DIR_CODIGO"]) {
                    $this->SetFillColor(200, 220, 255);
                    include_once("../include/class/DatoOtros.php");
                    $objDatosDir = new DatoOtros($this->db->conn);
                    $datosRem = $objDatosDir->obtieneDatosReales($rs->fields["SGD_DIR_CODIGO"]);
                    $this->SetFont('Arial', 'B', 12);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell($WIMP, 6, "Dependencia: " . $this->ChC($rs->fields["DEP"]), 0);
                    $this->SetFont('Arial', 'B', 10);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell($WIMP, 6, "Tipo: Original", 0);
                    $this->SetXY($this->GetX(), $this->GetY() + 10);
                    $this->MultiCell(75, 6, $this->ChC('Fecha de generación: ') . date('Y-m-d'), 0);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(50, 6, $this->ChC('FECHA DE RADICACIÓN: '), 1, 'J', 1);
                    $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                    $this->MultiCell(125, 6, substr($rs->fields["RADI_FECH_RADI"], 0, 10), 1, 'J', 0);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(50, 6, 'REMITENTE: ', 1, 'J', 1);
                    $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                    $this->MultiCell(125, 6, $this->ChC(utf8_decode($datosRem[0]['NOMBRE']) . " " . utf8_decode($datosRem[0]['APELLIDO'])), 1, 'J', 0);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(50, 6, $this->ChC('DIRECCIÓN: '), 1, 'J', 1);
                    $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                    $this->MultiCell(125, 6, $this->ChC(utf8_encode($datosRem[0]['DIRECCION'] . "(" . $datosRem[0]['DEPARTAMENTO'] . " / " . $datosRem[0]['MUNICIPIO'] . ")")), 1, 'J', 0);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(50, 6, 'DIGNATARIO: ', 1, 'J', 1);
                    $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                    $this->MultiCell(125, 6, utf8_decode($rs->fields["SGD_DIR_NOMBRE"]), 1, 'J', 0);
                    $this->SetXY($this->GetX(), $this->GetY() + 10);
                    $this->MultiCell(175, 6, 'ASUNTO', 1, 'J', 1);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(175, 6, utf8_decode($rs->fields["RA_ASUN"]), 1, 'J', 0);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(175, 6, 'ANEXOS', 1, 'L', 1);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(175, 6, utf8_decode($rs->fields["RADI_DESC_ANEX"]), 1, 'L', 0);
                    $this->SetXY($this->GetX(), $this->GetY());
                    $this->MultiCell(175, 6, 'TRD', 1, 'L', 1);
                    $this->SetXY($this->GetX(), $this->GetY());
                    if ($rs->fields["SGD_SRD_DESCRIP"])
                        $trd = $rs->fields["SGD_SRD_DESCRIP"] . "/" . $rs->fields["SGD_SRD_DESCRIP"] . "/" . $rs->fields["SGD_TPR_DESCRIP"] . "-Termino:" . $rs->fields["SGD_TPR_TERMINO"] . " D�as";
                    $this->MultiCell(175, 6, $trd, 1, 'C', 0);
                }
                if ($rs->fields["INFORMADO"]) {
                    while (!$rs->EOF) {
                        if ($rs->fields["USUACODIINF"]) {
                            $this->AddPage();
                            $this->SetFont('Arial', 'B', 12);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell($WIMP, 6, "Dependencia: " . $rs->fields["DEPINF"], 0);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->SetFont('Arial', 'B', 10);
                            $this->MultiCell($WIMP, 6, "Tipo: Copia Informativa", 0);
                            $this->SetXY($this->GetX(), $this->GetY() + 10);
                            $this->MultiCell(75, 6, $this->ChC('Fecha de generación: ' . date('Y-m-d'),'iso'), 0);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(50, 6, $this->ChC('FECHA DE RADICACIÓN: ','iso'), 1, 'J', 1);
                            $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                            $this->MultiCell(125, 6, substr($rs->fields["RADI_FECH_RADI"], 0, 10), 1, 'J', 0);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(50, 6, 'REMITENTE: ', 1, 'J', 1);
                            $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                            $this->MultiCell(125, 6, $datosRem[0]['NOMBRE'] . " " . $datosRem[0]['APELLIDO'], 1, 'J', 0);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(50, 6, $this->ChC('DIRECCIÓN: ','iso'), 1, 'J', 1);
                            $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                            $this->MultiCell(125, 6, $this->ChC($datosRem[0]['DIRECCION'] . "(" . $datosRem[0]['DEPARTAMENTO'] . " / " . $datosRem[0]['MUNICIPIO'] . ")",'iso'), 1, 'J', 0);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(50, 6, 'DIGNATARIO: ', 1, 'J', 1);
                            $this->SetXY($this->GetX() + 50, $this->GetY() - 6);
                            $this->MultiCell(125, 6, $this->ChC($rs->fields["SGD_DIR_NOMBRE"]), 1, 'J', 0);
                            $this->SetXY($this->GetX(), $this->GetY() + 10);
                            $this->MultiCell(175, 6, 'ASUNTO', 1, 'J', 1);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(175, 6, $this->ChC($rs->fields["RA_ASUN"]), 1, 'J', 0);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(175, 6, 'ANEXOS', 1, 'L', 1);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(175, 6, $this->ChC($rs->fields["RADI_DESC_ANEX"]), 1, 'L', 0);
                            $this->SetXY($this->GetX(), $this->GetY());
                            $this->MultiCell(175, 6, 'TRD', 1, 'L', 1);
                            $this->SetXY($this->GetX(), $this->GetY());
                            if ($rs->fields["SGD_SRD_DESCRIP"])
                                $trd = $this->ChC($rs->fields["SGD_SRD_DESCRIP"] . "/" . $rs->fields["SGD_SRD_DESCRIP"] . "/" . $rs->fields["SGD_TPR_DESCRIP"] . "-Termino:" . $rs->fields["SGD_TPR_TERMINO"] . " D�as",'iso');
                            $this->MultiCell(175, 6, $trd, 1, 'C', 0);
                        }
                        $rs->MoveNext();
                    }
                }
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    function enlacePDF($i = 0) {
        include("../config.php");
        $band = true;
        $archivo = "/tmp/hojaResumenRadPDF" . date('YmdHis') . "$i.pdf";
        ($this->Output("../" . $carpetaBodega . $archivo) == '') ? $band = "../seguridadImagen.php?fec=" . base64_encode($archivo) : $band = false;
        return $band;
    }

    function ChC($mystring, $from = 'utf') {
        if ($from == 'utf') {
            return iconv('UTF-8', 'windows-1252', $mystring);
        }else{
            return iconv('ISO-8859-1', 'windows-1252', $mystring);
        }
    }

    function barCode() {
        include("../config.php");
        $height = "50";
        $bgcolor = "#FFFFFF";
        $color = "#333366";
        $type = "png";
        $encode = "CODE39";
        $fechah = date("YmdHms");
        $height = "50";
        $scale = "0.1";
        $bdata = $this->radicado;
        $file = "../$carpetaBodega/tmp/$this->radicado" . "_" . $fechah . "";
        include("../include/barcode/barcode.php");
        $this->fileBar = $file . ".png";
    }

}

?>
