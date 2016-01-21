<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
/**
 * Modulo de Formularios Web para atencion a Ciudadanos.
 * @autor Carlos Barrero   carlosabc81@gmail.com SuperSolidaria
 * @author Sebastian Ortiz Vasquez 2012
 * @fecha 2009/05
 * @Fundacion CorreLibre.org
 * @licencia GNU/GPL V2
 *
 * Se tiene que modificar el post_max_size, max_file_uploads, upload_max_filesize
 */
$ruta_raiz = "../..";
include 'claseformunlario.php';
include 'cofigpqrs.php';
include $ruta_raiz."/include/tx/Historico.php";
include "radicar/Radicacion.php";
foreach ($_GET as $key => $valor)   ${$key} = $valor;//iconv("ISO-8859-1","UTF-8",$valor);
foreach ($_POST as $key => $valor)   ${$key} = $valor; //iconv("ISO-8859-1","UTF-8",$valor);



$objclaseformulario = new claseformunlario($ruta_raiz,$_FILES);
$objradi = new Radicacion($objclaseformulario->db);
$objhist = new Historico($objclaseformulario->db);
$usuariopqr = "select USUA_CODI from usuario where usua_perm_administracionpqr = 1 AND DEPE_CODI =  $dependencipqr";

$rs=$objclaseformulario->db->conn->Execute($usuariopqr);
$usuariopqr = $rs->fields['USUA_CODI'];
$objclaseformulario->usuariopqr=$usuariopqr;
$objclaseformulario->dependencia=$dependencipqr;

$objclaseformulario->db->conn->debug = false;
if($tipoid != 4)
{
    $sgdttrcodigo=1;
    $ciudadano=$objclaseformulario->crearCiudadano($tipoid, $primernombre,
                                        $segunnombre, $direcion,
                                        $primerapellido, $segundoapellido,
                                        $telefonooficina, $telefonomovil,
                                        $email, $munisipioresi,
                                        $departamentoresi, $numid,
                                        $continenteresi, $paisresi,$fax,$ocupacion,$profesion);

}
else
{
    $empresa = $objclaseformulario->crearEmpresa($tipoid, $paisresi,$primernombre,
                                                 $numid, $munisipioresi,
                                                 $departamentoresi, $direcion,
                                                 $telefonooficina, $telefonomovil);
    $sgdttrcodigo=2;
}

    
    $descripcionAnexos = $objclaseformulario->uploader->tieneArchivos?count($uploader->subidos):0;
    $descripcionAnexos .=  " Anexos";
      
      $objradi->radiCuentai = "''";
      $objradi->mrecCodi = 3;
      $objradi->radiNumeDeri=0;
      $objradi->usuaCodi = $usuariopqr;
      $objradi->radiPais = $paisresi;
      $objradi->raAsun = $mensaje;
      $objradi->descAnex = "'".$descripcionAnexos."'";
      $objradi->radiDepeRadi = $dependencipqr;
      $objradi->radiUsuaActu = $usuariopqr;
      $objradi->carpCodi = 0;
      $objradi->trteCodi=0;
      $objradi->dependencia = $dependencipqr;
      $objradi->radiDepeActu = $dependencipqr;
      $objradi->tdocCodi = $tdoccodigo;
      $objradi->tdidCodi="''";
      $objradi->sgd_apli_codi=1; 
      $objradi->nivelRad = 0;
    $numeroRadicado = $objradi->newRadicado(2, $dependencipqr,1);
    
    $objclaseformulario->cargarArchivos($dependencipqr,$numeroRadicado,$adjuntosSubidos);
    if($numeroRadicado)
    {

       $codigodir=  $objclaseformulario->direciones($num_dir, $empresa,
                                    $ciudadano, $numeroRadicado,
                                    $munisipioresi, $departamentoresi,
                                    $direcion, $primernombre,
                                    $segunnombre, $primerapellido,
                                    $segundoapellido, $sgdttrcodigo,
                                    $numid, $paisresi,
                                    $continenteresi, $email,$conticonta,
                                    $paisconta,$departaconta,$municonta,
                                    $direcioncontac,$emailconta,
                                    $telefonocontac,$celularcontac);
         
        
        $objhist->insertarHistorico($numeroRadicado, $dependencipqr, $usuariopqr, $dependencipqr, $usuariopqr, "....", 2);
      
       $objclaseformulario->AnexarArchivos($numeroRadicado, $dependencipqr,$usuariopqr);
       
include 'funciones.php';   
require('barcode.php');
include_once "../config.php";

$textpdf= ("Señor(a) " .$primernombre." ".$segunnombre."".$primerapellido." ".$segundoapellido.", Número de identificación: ".$numid.", gracias por utilizar los canales de Atención al Ciudadano del servicio geologico colombiano, usted ha recibido el radicado de su PQR número " .$numeroRadicado. " de fecha ".date("Y/m/d")." a las " .date("H:i:s").
        ", con este podrá realizar el seguimiento de su solicitud y conocer su estado,  para realizarlo usted deberá consultar el siguiente link: http://sgc.gov.co Al ingresar usted deberá digitar el número del radicado y verificar (".$codigoverificacion.") el estado de su PQR.");
$textpdf= utf8_encode($textpdf);

$sql_depeNomb = "select depe_nomb from dependencia where depe_codi = ". $dependencipqr;
				$rs_depeNomb = $objclaseformulario->db->conn->Execute($sql_depeNomb);
				if(!$rs_depeNomb->EOF){
					$depeNomb = substr($rs_depeNomb->fields["depe_nomb"],0,40);
				}

$sql_muniNomb = "select muni_nomb from municipio where muni_codi = ".$munisipioresi . " and dpto_codi = " .$departamentoresi ;
				$rs_muniNomb = $objclaseformulario->db->conn->Execute($sql_muniNomb);
				if(!$rs_muniNomb->EOF){
					$muniNomb = $rs_muniNomb->fields["muni_nomb"];
				}else {
					$muniNomb = "";
				}

$sql_deptoNomb = "select dpto_nomb from departamento where dpto_codi = ".$departamentoresi. " and id_pais = $paisresi";
				$rs_deptoNomb = $objclaseformulario->db->conn->Execute($sql_deptoNomb);
				if(!$rs_deptoNomb->EOF){
					$deptNomb = $rs_deptoNomb->fields["dpto_nomb"];
				}else{
					$deptNomb = "";	
				}

$sql_paisNomb = "select nombre_pais from sgd_def_paises where id_pais = ". $paisresi;
                                $rs_paisNomb = $objclaseformulario->db->conn->Execute($sql_paisNomb);
                                if(!$rs_paisNomb->EOF){
                                        $paisNomb = $rs_paisNomb->fields["nombre_pais"];
                                }else{
                                        $paisNomb = "No Registra";
                                }


				
$pdf=new PDF_Code39();
$pdf->AddPage();
//codigoverificacion es un randon
$pdf->Code39(110,25,$numeroRadicado,1,8);
$pdf->Text(130,37,textoPDF("Radicado N°. ".$numeroRadicado));
$pdf->Text(110,41,textoPDF(date('d')." - ".date('m')." - ".date('Y')." ".date('h:i:s')) . "   Folios: N/A (WEB)   Anexos: ". $cantidadadjuntos );
$pdf->SetFont('Arial','',8);
$pdf->Text(110,45,textoPDF("Destino: ". $depeRadicaFormularioWeb . " " . substr($nombredeparta, 0,10) ." - Rem/D: ".
substr($primernombre." ".$segunnombre,0,10)." ".$primerapellido." ".$segundoapellido."",0,10));
$pdf->SetFont('Arial','',7);
$pdf->Text(110,48,textoPDF (utf8_encode("Consulte el estado de su trámite en nuestra página web http://www.sgc.gov.co")));
$pdf->Text(135,51,textoPDF(utf8_encode("Código de verificación: " . $codigoverificacion)));
$pdf->Text(12,67,textoPDF(utf8_encode("Bogotá D.C., ".date('d')." de ".nombremes(date('m'))." de ".date('Y'))));
$pdf->Text(12,81,textoPDF (utf8_encode("Señor(a)")));
$pdf->SetFont('','B');
$pdf->Text(12,85,textoPDF(($primernombre." ".$segunnombre)." ".$primerapellido." ".$segundoapellido));
$pdf->SetFont('','');
//$pdf->Text(12,89,textoPDF("Ciudad"));
$pdf->Text(12,99,textoPDF("Asunto : ".mb_strtoupper($tema,"utf-8")));
$pdf->SetXY(11,105);
$pdf->MultiCell(0,4,textoPDF($textpdf));
$pdf->MultiCell(0,6,$_SESSION['desc'],0);
$pdf->Text(12,236,"Atentamente,");
$pdf->SetFont('','B');
$pdf->Text(12,246,textoPDF($entidad_largo));
$pdf->SetFont('','');

 $anoRad = date("Y");
        
            
$rutaPdf ="/$anoRad/".$dependencipqr."/$numeroRadicado".".pdf";
     

$pdf->Output($ruta_raiz."/poolsgc2013".$rutaPdf,'F');

//Realizar el conteo de hojas del radicado final//
$conteoPaginas = getNumPagesPdf($ruta_raiz."/poolsgc2013".$rutaPdf);

$sqlu = "UPDATE radicado SET radi_nume_hoja= $conteoPaginas where radi_nume_radi=" . $numeroRadicado;


$objclaseformulario->db->conn->Execute($sqlu);

//


$objclaseformulario->updateRadicado($tema, $formulario, $numeroRadicado,$rutaPdf,$tipoid);
$objclaseformulario->enviarcorreo($mensaje, $email,$rutaPdf,$tema,$formulario);



$objclaseformulario->asignarMTRD($formulario, $dependencipqr, $numeroRadicado,$usuariopqr);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
     <html xmlns="http://www.w3.org/1999/xhtml">
     <head>
<!-- Meta Tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!--Deshabilitar modo de compatiblidad de Internet Explorer-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <title>Entidad Usuaria de Orfeo -</title>
    <link rel="stylesheet" href="css/structure.css" type="text/css" />
    </head>

<body>
<p>&nbsp;</p>
<table width="80%" border="0" align="center" cellpadding="0"
	cellspacing="0" bgcolor="#FFFFFF" class="table table-responsive">
	<tr>
		<td align="center"><br />
                    <img src="../../logoEntidad3.png" width="115px" height="130px" />
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

    <img width="200px" height="150px" src='../../lema.png'>
                </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<?php if(1==1){?>
	<tr>
	<td align="center">
            Su solicitud ha sido registrada de forma exitosa con el radicado No. <b><?=$numeroRadicado?></b> y c&oacute;digo de verificaci&oacute;n <b><?=$codigoverificacion ?></b>.
	Por favor tenga en cuenta estos datos para que realice la consulta del estado a su solicitud a trav&eacute;s de la p&aacute;gina web de la Superintendencia.
	</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">Pulse continuar para <b>terminar la solicitud</b> y
		visualizar el documento en formato PDF. Si desea almacenarlo en su
		disco duro o impr&iacute;malo.</td>
	</tr>
	<tr>
		<td align="center">&nbsp;</td>
	</tr>
	<tr>
		<td align="center"><input type="button" name="Submit"
			value="Continuar"
			onclick="window.open('<?=$ruta_raiz?>/poolsgc2013/<?=$rutaPdf?>')" />
			<input type="button" name="Cerrar"
			value="Cerrar"
			onclick="window.location='http://www.sgc.gov.co/'" />
	</tr>
	<tr>
		<td align="center">&nbsp;</td>
	</tr>
	<?php } else if ($errorFormulario==1){?>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td><font color=red><b>Existe un error en su c&oacute;digo de
		verificaci&oacute;n o est&aacute; intentando enviar una petici&oacute;n de nuevo.</b></font></td>


		<tr />
		<td>
		<form name=back action="javascript:history.go(-1)()" method=post><input
			type=submit value="Atr&aacute;s"></form>
		</td>
		<?php } else if($errorFormulario==2){?>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td><font color=red><b>Ocurrió un error en al subida de archivo</b></font></td>
			<tr>
			<td>
			<?php echo implode($uploader->messages);?>
			</td>
			</tr>
		</tr>
		<td>
		<form name=back action="javascript:history.go(-1)()" method=post><input
			type=submit value="Atr&aacute;s"></form>
		</td>

		<?php }?>

</table>
</body>
</html>