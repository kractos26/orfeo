<?php
session_start();
$ruta_raiz = "..";
!$ruta_raizImg?$ruta_raizImg = "..":0;
include($ruta_raiz.'/config.php');
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if($db)
{
        //$db->conn->debug=true;
	if(!$frmActual)$frmActual=$_SERVER['PHP_SELF'];
	if($numExpediente)
	{
		include_once ("$ruta_raiz/include/tx/Expediente.php");
		include_once("$ruta_raiz/class_control/Dependencia.php");
		include_once("$ruta_raiz/include/tx/Historico.php");
		$objDep = new Dependencia($db);
		$expediente = new Expediente($db);
		
		if(isset($_POST['btnMoverCarp']))
		{
			if(isset($_POST['checkRads']))
			{
				$Historico = new Historico($db);
				foreach($_POST['checkRads'] as $rads=>$valu)
				{
					if($_POST['selCarpetas']==0)
					{
						
						$sqlDel="delete from sgd_exp_radcarpeta where sgd_carpeta_id in (select sgd_carpeta_id from sgd_carpeta_expediente where sgd_exp_numero='$numExpediente') and radi_nume_radi=$rads";
						$rsDel=$db->conn->Execute($sqlDel);
						if($rsDel)
						{	
							$codiRegE[0]=$rads;  
							$radiModi = $Historico->insertarHistoricoExp($numExpediente,$codiRegE , $_SESSION['dependencia'], $_SESSION['codusuario'],"Radicado sin carpeta", 66, 0);
						}
					}
					else
					{
						$sqlDel="delete from sgd_exp_radcarpeta where sgd_carpeta_id in (select sgd_carpeta_id from sgd_carpeta_expediente where sgd_exp_numero='$numExpediente') and radi_nume_radi=$rads";
						$rsDel=$db->conn->Execute($sqlDel);
						$sqlIns="insert into sgd_exp_radcarpeta(radi_nume_radi,sgd_carpeta_id) values($rads,".$_POST['selCarpetas'].")";
						$rsIns=$db->conn->Execute($sqlIns);
						if($rsIns)
						{
							$sql="select * from sgd_carpeta_expediente where sgd_carpeta_id=".$_POST['selCarpetas'];
							$rs=$db->conn->Execute($sql);
							$codiRegE[0]=$rads;
							$radiModi = $Historico->insertarHistoricoExp($numExpediente,$codiRegE , $_SESSION['dependencia'], $_SESSION['codusuario'],"Se incluye Radicado en la carpeta No [".$rs->fields['SGD_CARPETA_NUMERO']."] ".$rs->fields['SGD_CARPETA_DESCRIPCION'], 66, 0);
						}
					}
					
				}
			}
		}
		$sql1  = "select '['".$db->conn->concat_operator."sgd_carpeta_numero".$db->conn->concat_operator."'] '".$db->conn->concat_operator."'-' ".$db->conn->concat_operator.$db->conn->substr."(sgd_carpeta_descripcion,0,60) as ver, ";
		$sql1 .= "sgd_carpeta_id as ID from  sgd_carpeta_expediente where sgd_exp_numero='$numExpediente' order by 1";
		($rsSel=$db->conn->Execute($sql1)) ? $error = $error : $error = 3;
		$slcCarp=$rsSel->GetMenu( 'selCarpetas', $selCarpetas, '0: Sin Carpeta', false, false, " id='selCarpetas' class='select' ", false );
		
		$mrdCodigo       = $expediente->consultaTipoExpediente("$numExpediente");
		$trdExpediente 	 = $expediente->codiSRD.'-'.$expediente->descSerie." / ".$expediente->codiSBRD.'-'.$expediente->descSubSerie;
		$expediente->getExpediente($numExpediente);
                if($expediente->nivelExp==0)$nvExp="P&uacute;blico";
                else if($expediente->nivelExp > 0 )
                {
                    $tblSinPermiso="<html>
                                    <head><title>Seguridad Expediente</title><link href='$ruta_raizImg/estilos/orfeo.css' rel='stylesheet' type='text/css'></head>
                                    <body>
                                    <table border=0 width=100% align='center' class='borde_tab' cellspacing='0'>
                                    <tr align='center' class='titulos2'>
                                         <td height='15' class='titulos2'>!! SEGURIDAD !!</td>
                                    </tr>
                                    <tr >
                                         <td width='38%' class=listado5 ><center><p><font class='no_leidos'>NO TIENE PERMISOS PARA ACCEDER AL EXPEDIENTE No. $numExpediente,<br>Este Expediente est&aacute; marcado como confidencial.</font></p></center></td>
                                    </tr>
                                    <tr >
                                            <td height='15' class='titulos2'><center>Favor comunicarse con: ".$expediente->responsableNom." Dependencia: ".$expediente->depeNomb."</center></td>
                                    </tr>
                                    </table>
                                    </body>
                                    </html>";
                    if($expediente->nivelExp==1 && $_SESSION["usua_admin_archivo"]<1 || ($expediente->nivelExp==1 and $expediente->fase<2))
                    {
                        if($expediente->responsable!=$_SESSION['usua_doc'] && $expediente->responsable!=$_SESSION['usua_doc'])
                        {
                            die($tblSinPermiso);
                        }
                        $nvExp="Privado";
                    }
                    if($expediente->nivelExp==2 && $_SESSION["usua_admin_archivo"]<1 || ($expediente->nivelExp==2 and $expediente->fase<2))
                    {
                        if($expediente->depCodi!=$_SESSION['dependencia'] && $expediente->responsable!=$_SESSION['usua_doc'])
                        {
                            die($tblSinPermiso);
                        }
                        $nvExp="Dependencia";
                    }
                    if($expediente->nivelExp==3 && $_SESSION["usua_admin_archivo"]<1  || ($expediente->nivelExp==3 and $expediente->fase<2))
                    {
                        $sql="select * from sgd_matriz_nivelexp where sgd_exp_numero='$numExpediente' and usua_login='".$_SESSION['krd']."'";
                        $rsVerif=$db->conn->Execute($sql);
                        if($rsVerif && $rsVerif->EOF && $expediente->responsable!=$_SESSION['usua_doc'])
                        {
                            die($tblSinPermiso);
                        }
                        $nvExp="Usuario Especifico";
                    }
                }
                $depExp=$expediente->depeNomb;
		$tablaCreaCarpeta ="<tr>
					<td class='titulos5' colspan='4' align='center'><input type='button' name='btnCreaCarp' value='Adm Carpetas' class='botones_mediano2' onclick=\"creaCarpeta('".base64_encode($numExpediente.'%')."');\"></td>
					<td class='titulos5' colspan='3' align='right'>Archivar en : &nbsp;$slcCarp &nbsp;<input type='submit' name='btnMoverCarp' value='>>' class='botones_2' onclick='return valida();' ></td>
       				     </tr>";
		include_once($ruta_raiz.'/include/query/queryver_datosrad.php');
		$fecha = $db->conn->SQLDate("d-m-Y H:i A","a.RADI_FECH_RADI");
                $isql = "select r.*,c.sgd_tpr_descrip, " . $fecha . "as FECHA_RAD ,
						a.RADI_CUENTAI, a.RA_ASUN ,a.RADI_PATH ,$radi_nume_radi as RADI_NUME_RADI , ce.sgd_carpeta_id, ce.sgd_carpeta_numero,".$db->conn->substr."(ce.sgd_carpeta_descripcion,0,60) as sgd_carpeta_descripcion, ce.sgd_carpeta_csc
                         ,a.sgd_spub_codigo, a.codi_nivel, a.radi_usua_actu, a.radi_depe_actu
				 from sgd_exp_expediente r
				 join radicado a on r.radi_nume_radi=a.radi_nume_radi
				 join SGD_TPR_TPDCUMENTO c on a.tdoc_codi=c.sgd_tpr_codigo
				 join sgd_sexp_secexpedientes sexp on sexp.sgd_exp_numero=r.sgd_exp_numero
				 left join sgd_exp_radcarpeta cr on a.radi_nume_radi=cr.radi_nume_radi and sgd_carpeta_id in (select sgd_carpeta_id from sgd_carpeta_expediente where sgd_exp_numero='$numExpediente')
				 left join sgd_carpeta_expediente ce on ce.sgd_carpeta_id=cr.sgd_carpeta_id and r.sgd_exp_numero=ce.sgd_exp_numero
				 where
					r.sgd_exp_numero='$numExpediente'
		         and r.SGD_EXP_ESTADO <> 2
				 order by ce.sgd_carpeta_id, a.RADI_FECH_RADI DESC";
 		$rs = $db->conn->query($isql);
                
		if($rs && !$rs->EOF)
		{
			 $tablaRads ="<table  width=100% class='borde_tab' align='center' cellpadding='0' cellspacing='0'>
			 			 	<tr class='timparr'>
								<td colspan='8' class='titulos2'><center><font><b>Documentos Pertenecientes al expediente &nbsp;</b></font></center></td>
							</tr>
			 				$tablaCreaCarpeta
			 				<tr class='titulos2' >
						    <td align='center' colspan='3'> Radicado </td>
						    <td align='center'>Fecha Radicaci&oacute;n </td>
							<td align='center'>Tipo<br> Documento</td>
						    <td align='center'>Referencia<br>(Cuenta Interna, Oficio)</td>
							<td align='center'>Asunto</td>
						    <td align='center'>&nbsp;";
			
			 $tablaRads .="<input  type='checkbox' name='checkAll' value='checkAll' onclick='markAll();' >";
			 $tablaRads .="</tr>";
			 $i = 0;
			 $idCarpet=$rs->fields["SGD_CARPETA_ID"];
			 $descCarp="[".$rs->fields["SGD_CARPETA_NUMERO"]."] -".$rs->fields["SGD_CARPETA_DESCRIPCION"];
			 $conCarp = "<tr><td valign='baseline' class='listado1' colspan='8'><img src='$ruta_raizImg/iconos/folder_open.gif' title=' Radicados incluidos en :5' height='18' width='18'><font class='no_leidos'> $descCarp</font></td></tr>";
			 $sinCarp = "<tr><td valign='baseline' class='listado1' colspan='8'><font class='no_leidos'>Radicados sin carpeta</font></td></tr>";
			 if($idCarpet) $tablaRads.= $conCarp;
			 else $tablaRads.= $sinCarp;
			 while(!$rs->EOF) 
			 {
				$radicado_d = "";
				$radicado_path = "";
				$radicado_fech = "";
				$radi_cuentai = "";
				$rad_asun = "";
				$tipo_documento_desc = "";
				$radicado_d = $rs->fields["RADI_NUME_RADI"];
				$radicado_path = $rs->fields["RADI_PATH"];
				$radicado_fech = $rs->fields["FECHA_RAD"];
				$radi_cuentai = $rs->fields["RADI_CUENTAI"];
				$rad_asun = $rs->fields["RA_ASUN"];
				$tipo_documento_desc = $rs->fields["SGD_TPR_DESCRIP"];
				$subexpediente = $rs->fields["SGD_EXP_SUBEXPEDIENTE"];
                                $seguridadRadicado=$rs->fields["SGD_SPUB_CODIGO"];
                                $nivelRadicado=$rs->fields["CODI_NIVEL"];
                                $usuaCodiActu=$rs->fields["RADI_USUA_ACTU"];
                                $depeCodiActu=$rs->fields["RADI_DEPE_ACTU"];
                               
				if($idCarpet==$rs->fields["SGD_CARPETA_ID"])
				{
                                        $linkDocto="<a class='vinculos' href='javascript:noPermiso(0)' >$radicado_d</a> ";
                                        $linkInfGeneral="<a class='vinculos' href='javascript:noPermiso(0)' >$radicado_fech</a> ";
                                        if(strlen($radicado_path))$linkDoctoImg = "<a href='$ruta_raizImg/seguridadImagen.php?fec=".base64_encode($radicado_path)."'&ln=".base64_encode("check")."><span class=leidos>$radicado_d </span></a>";
                                        else $linkDoctoImg=$radicado_d;
                                        $linkInfGeneralRad = "<a href='$ruta_raizImg/verradicado.php?verrad=$radicado_d&PHPSESSID=".session_id()."&krd=$krd&carpeta=8&nomcarpeta=Busquedas&tipo_carp=0&menu_ver_tmp=3' target='accedeRadicado'><span class=leidos>$radicado_fech</span></a>";
                                        if($nivelRadicado <=$nivelus)
                                        {
                                            if($seguridadRadicado==1)
                                            {
                                                if( $usuaCodiActu ==$_SESSION['codusuario'] && $depeCodiActu==$_SESSION['dependencia'] )
                                                {
                                                    $linkDocto     =$linkDoctoImg;
                                                    $linkInfGeneral=$linkInfGeneralRad;
                                                }
                                                else
                                                {
                                                    $linkDocto="<a class='vinculos' href='javascript:noPermiso(1)' > $radicado_d</a>";
                                                    $linkInfGeneral=$linkInfGeneralRad;
                                                }
                                            }
                                            else
                                            {
                                                $linkDocto=$linkDoctoImg;
                                                $linkInfGeneral=$linkInfGeneralRad;
                                            }
                                        }
                                        if($seguridadRadicado==2)
                                        {
                                            if( $depePublica == $_SESSION['dependencia'])
                                            {
                                                $linkDocto     =$linkDoctoImg;
                                                $linkInfGeneral=$linkInfGeneralRad;
                                            }
                                            else
                                            {
                                                $linkDocto="<a class='vinculos' href='javascript:noPermiso(1)' >$radicado_d</a> ";
                                                $linkInfGeneral=$linkInfGeneralRad;
                                            }
                                        }
                                        if($seguridadRadicado==3)
                                        {
                                            $sql="select * from sgd_matriz_nivelrad where radi_nume_radi=$radicado_d and usua_login='".$_SESSION['krd']."'";
                                            $rsVerif=$db->conn->Execute($sql);
                                            if($rsVerif && !$rsVerif->EOF or ($usuaCodiActu ==$_SESSION['codusuario'] && $depeCodiActu==$_SESSION['dependencia']) )
                                            {
                                                $linkDocto     =$linkDoctoImg;
                                                $linkInfGeneral=$linkInfGeneralRad;
                                            }
                                            else
                                            {
                                                $linkDocto="<a class='vinculos' href='javascript:noPermiso(1)' >$radicado_d</a> ";
                                                $linkInfGeneral=$linkInfGeneralRad;
                                            }
                                        }
                                        $tablaRads.="<tr class='tpar'>
                                                            <td valign='baseline' class='listado1'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td valign='baseline' class='listado1'>";
					if( !isset( $_POST['verBorrados'] ) )
					{
						if( ( $_POST['anexosRadicado'] != $radicado_d ) )
					    {
					          $tablaRads .="<img name='imgVerAnexos_$radicado_d' src='$ruta_raizImg/imagenes/menu.gif' border='0'>";
					    }
					    else if( ( $_POST['anexosRadicado'] == $radicado_d ) )
					    {
					          $tablaRads .="<img name='imgVerAnexos_$radicado_d' src='$ruta_raizImg/imagenes/menuraya.gif' border='0'>";
					    }
					 }
					 else
					 {
					 	if( ( $_POST['verBorrados'] == $radicado_d ) )
					    {
					          $tablaRads .="<img name='imgVerAnexos_$radicado_d' src='$ruta_raizImg/imagenes/menuraya.gif' border='0'>";
					    }
					    else if( ( $_POST['verBorrados'] != $radicado_d ) )
					    {
					          $tablaRads .="<img name='imgVerAnexos_$radicado_d' src='$ruta_raizImg/imagenes/menu.gif' border='0'>";
					    }
					  }
					  
					  $tablaRads.="</td>";
					  $tablaRads.="<td valign='baseline' class='listado1'>
					  				<span class='leidos'>$linkDocto</span>
					  				</td>
					  				<td valign='baseline' class='listado1' align='center' width='100'><span class='leidos2'>&nbsp;$linkInfGeneral&nbsp;</span></td>
					  				<td valign='baseline' class='listado1' ><span class='leidos2'>&nbsp;$tipo_documento_desc&nbsp;</span></td>
					  				<td valign='baseline' class='listado1' ><span class='leidos2'>&nbsp;$radi_cuentai &nbsp;</span></td>
					  				<td valign='baseline' class='listado1'><span class='leidos2'>&nbsp;$rad_asun&nbsp;</span></td>
					  				<td  class='listado1'></center>";
					 // if(($expediente->responsable==$_SESSION['usua_doc'] && $expediente->fase<2 and $expediente->depCodi==$_SESSION['dependencia'] )|| ($_SESSION["usua_admin_archivo"]>=1 and $expediente->fase>=2))
					  //{
					  	$tablaRads.="<input  type='checkbox' name='checkRads[$radicado_d]' value='on'> </center></td>";					  
					 // }
					  $tablaRads.="</tr>";
					  
					  include_once "$ruta_raiz/class_control/anexo.php";
					  include_once "$ruta_raiz/class_control/TipoDocumento.php";
					  $a = new Anexo($db->conn);
					  $tp_doc = new TipoDocumento($db);
					  $num_anexos = $a->anexosRadicado($radicado_d, true);
					  $anexos_radicado=$a->anexos;
					  //if( isset( $_POST['verBorrados'] ) )
					  //{
		 			   //   $num_anexos = $a->anexosRadicado( $radicado_d, true );
					  //}
					  if($num_anexos>=1)
					  {
							for($i=0;$i<=$num_anexos;$i++)
							{
								$anex = $a;
								$codigo_anexo = $a->codi_anexos[$i];
								if($codigo_anexo and substr($anexDirTipo,0,1)!='7')
								{
									$tipo_documento_desc = "";
									$fechaDocumento = "";
									$anex_desc = "";
									$anex->anexoRadicado($radicado_d,$codigo_anexo);
									$secuenciaDocto   = $anex->get_doc_secuencia_formato($dependencia);
									$fechaDocumento   = $anex->get_sgd_fech_doc();
									$anex_nomb_archivo= $anex->get_anex_nomb_archivo();
									$anex_desc= $anex->get_anex_desc();
									$dependencia_creadora= substr($codigo_anexo,4,3);
									$ano_creado= substr($codigo_anexo,0,4);
									$sgd_tpr_codigo   = $anex->get_sgd_tpr_codigo();
									$anexBorrado = $anex->anex_borrado;
									$anexSalida = $anex->get_radi_anex_salida();
									$ext = substr($anex_nomb_archivo,-3);
									/**
										*   Trae la descripcion del tipo de Documento del anexo
										**/
									if($sgd_tpr_codigo)
									{
									  //$tp_doc = new TipoDocumento($db->conn);
									  $tp_doc->TipoDocumento_codigo($sgd_tpr_codigo);
									  $tipo_documento_desc = $tp_doc->get_sgd_tpr_descrip();
									}
									if( $anexBorrado == "S" ){
										$imgTree="docs_tree_del.gif";
										$idBorrados="id='borrados' style='display:none'";
									}
							        else if( $anexBorrado == "N" )
							        {
							        	$imgTree="docs_tree.gif";
							        	$idBorrados="id='anex'";
							        }
									if(trim($anex_nomb_archivo) and $anexSalida!=1 )
									{
										$tablaRads.="<tr  class='timpar' $idBorrados>
									      				<td valign='baseline' class='listado5'>&nbsp;</td>
									  	  				<td valign='baseline'  class='listado5'><img src='$ruta_raizImg/iconos/$imgTree'><a href='$ruta_raizImg/seguridadImagen.php?fec=".base64_encode($ano_creado."/$dependencia_creadora/docs/$anex_nomb_archivo")."&ln=".base64_encode("check")."'>".substr($codigo_anexo,-4)."</a></td>
											 			<td valign='baseline' class='listado5'>&nbsp;</td>
													  	<td valign='baseline' class='listado5'>$fechaDocumento </td>
													  	<td valign='baseline' class='listado5'>$tipo_documento_desc</td>
													  	<td valign='baseline' class='listado5'>&nbsp;</td>
													  	<td valign='baseline' class='listado5'>$anex_desc</td>
													  	<td valign='baseline'  class='listado5'></td>
												  	</tr>";
										
								   	} // Fin del if que busca si hay link de archivo para mostrar o no el doc anexo
								}
							}  // Fin del For que recorre la matriz de los anexos de cada radicado perteneciente al expediente
						}
						$idCarpet=$rs->fields["SGD_CARPETA_ID"];
						$rs->MoveNext();
					}
					else
					{	
						$descCarp="[".$rs->fields["SGD_CARPETA_NUMERO"]."] -".$rs->fields["SGD_CARPETA_DESCRIPCION"];
						$conCarp = "<tr><td valign='baseline' class='listado1' colspan='8'><img src='$ruta_raizImg/iconos/folder_open.gif' title=' Radicados incluidos en :5' height='18' width='18'> <font class='no_leidos'>$descCarp</font></td></tr>";
						$sinCarp = "<tr><td valign='baseline' class='listado1' colspan='8'><font class='no_leidos'>Radicados sin carpeta </font></td></tr>";
						$idCarpet=$rs->fields["SGD_CARPETA_ID"];
						if($idCarpet) $tablaRads.= $conCarp;
						else $tablaRads.= $sinCarp;
					}
				}
				$tablaRads.="</table>";
		}
		else
		{
			$tablaRads.="<table  width=100% class='borde_tab' align='center' cellpadding='0' cellspacing='0'>
						<tr class='timparr'>
							<td colspan='6' class='titulos2'><center><font><b>Actualmente no tiene Radicados Archivados</b></font></center></td>
						</tr>
						</table>";
		}
	
		
	}
	if($verrad && $expediente)
	{
		$arrAnexoAsociado = $expediente->expedienteAnexoAsociado($verrad,$numExpediente);
		if( is_array($arrAnexoAsociado) && count($arrAnexoAsociado)>0 )
		{
			 include_once "$ruta_raiz/include/tx/Radicacion.php";
		     $rad = new Radicacion( $db );
			 $tblAnexAsoc="<table width='100%' class='borde_tab' cellspacing='0' cellpadding='0' align='center' id='tblAnexoAsociado'>
		  					<tr>
		    					<td class='titulos5'>Y ESTA RELACIONADO CON EL(LOS) SIGUIENTE(S) DOCUMENTOS:</td>
		    					<td class='titulos5' align='center'>";
			//if(($expediente->responsable==$_SESSION['usua_doc'] && $expediente->fase<2 and $expediente->depCodi==$_SESSION['dependencia'] ) || ($_SESSION["usua_admin_archivo"]>=1 and $expediente->fase>=2))
		    //{
		      	
		      	$tblAnexAsoc .="<span class='leidos2'><b>ARCHIVAR DOCUMENTOS EN EXPEDIENTE:</b></span><input type='submit' name='btnAanexoAsociado' value='>>' class='botones_2' onclick='return validaAA();' >";
		    //}
		    $tblAnexAsoc .="</td>
							  </tr>
							</table>
							<table border=0 width=100% class='borde_tab' align='center'>
							  <tr class='titulos5'>
							    <td class='titulos5'><input type='checkbox' name='checkTodosInc' id='checkTodosInc' value='checkbox' onClick='todosInc();'></td>
							    <td align='center'>RADICADO</td>
							    <td align='center'>FECHA RADICACION</td>
							    <td align='center'>TIPO DOCUMENTO</td>
							    <td align='center'>ASUNTO</td>
							    <td align='center'>TIPO DE RELACION</td>
							  </tr>";
		         foreach( $arrAnexoAsociado as $clave => $datosAnexoAsociado )
		        {
		           
		                $arrDatosRad = $rad->getDatosRad( $datosAnexoAsociado['radicado'] );
		                if( $arrDatosRad['ruta'] != "" )
		                {
		                    $rutaRadicado = "<a href='$ruta_raizImg/seguridadImagen.php?fec=".base64_encode($arrDatosRad['ruta'])."&ln=".base64_encode("check")."' >".$datosAnexoAsociado['radicado']."</a>";
		                }
		                else
		                {
		                    $rutaRadicado = $datosAnexoAsociado['radicado'];
		                }
		                $radicadoAnexo = $datosAnexoAsociado['radicado'];
		                $tipoRelacion = $datosAnexoAsociado['tipoAsoc'];
		  	 			$tblAnexAsoc .="<tr class='listado5'>
									    	<td><input type='checkbox' name='chkRadsInc[$radicadoAnexo]' id='chkRadsInc[$radicadoAnexo]' value='$radicadoAnexo'></td>
									    	<td>$rutaRadicado</td>
									    	<td><a href='$ruta_raizImg/verradicado.php?verrad=$radicadoAnexo&".session_name()."=".session_id()."&krd=$krd' target='VERRAD$radicadoAnexo'>".$arrDatosRad['fechaRadicacion']."</a></td>
									    	<td>".$arrDatosRad['tipoDocumento']."</td>
									    	<td>".$arrDatosRad['asunto']."</td>
									    	<td>".$tipoRelacion."</td>
							  	 		</tr>";
							  
		     }
		     $tblAnexAsoc .="</table>";
		}
	}
}
?>

<link rel="stylesheet" href="<?=$ruta_raiz?>/estilos/orfeo.css">
<script language="JavaScript" src="<?=$ruta_raiz?>/js/funciones.js"></script>
<script>
function regresar()
{
	window.document.frmExp.action=<?="'".$_SERVER['PHP_SELF']."?numExpediente=$numExpediente&numExpActual=$numExpediente'"?>;
	window.document.frmExp.submit();
	//window.close();
}

function Responsable(numeroExpediente) 
{
	window.open("<?=$ruta_raiz?>/expediente/responsable.php?&numeroExpediente="+numeroExpediente+"&krd=<?=$krd?>","Responsable","height=300,width=450,scrollbars=yes");
}

function modFlujo(numeroExpediente,texp,codigoFldExp)
{
	window.open("<?=$ruta_raiz?>/flujo/modFlujoExp.php?codigoFldExp="+codigoFldExp+"&krd=<?=$krd?>&numeroExpediente="+numeroExpediente+"&texp="+texp+"&krd=<?=$krd?>","TexpE<?=$fechaH?>","height=250,width=750,scrollbars=yes");
}

function markAll()
{
	if(document.frmExp.elements['checkAll'].checked)
	for(i=1;i<document.frmExp.elements.length;i++)
	document.frmExp.elements[i].checked=1;
	else
		for(i=1;i<document.frmExp.elements.length;i++)
		document.frmExp.elements[i].checked=0;
}

function crearProc(numeroExpediente)
{
	 window.open("<?=$ruta_raiz?>/expediente/crearProceso.php?sessid=<?=session_id()?>&numeroExpediente="+numeroExpediente+"&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>","HistExp<?=$fechaH?>","height=320,width=600,scrollbars=yes");
}

function creaCarpeta(exp)
{
	windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=550,height=250";
	 window.open( "<?=$ruta_raiz?>/expediente/carpetaExp.php?sessid=<?=session_id()?>&expNum="+exp+"&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>","subExp<?=$fechaH?>",windowprops );
}

function valida()
{
	marcados = 0;
	for(i=0;i<document.frmExp.elements.length;i++)
	{	if(document.frmExp.elements[i].checked==1 )
		{
			marcados++;
        }
        
    }
	if(marcados>=1)
	{
	  return true;
	}
	else
	{
		alert("Debe marcar un elemento");
		return false;
	}
}

function verHistExpediente(numeroExpediente,codserie,tsub,tdoc,opcionExp) {
  var pagHist = window.open("<?=$ruta_raiz?>/expediente/verHistoricoExp.php?sessid=<?=session_id()?>&opcionExp="+opcionExp+"&numeroExpediente="+numeroExpediente+"&krd=<?=$krd?>","HistExp<?=$fechaH?>","scrollbars,fullscreen");
}

function verBorrados() 
{ 
	if( document.getElementById("borrados"))
	{
	      borrado = document.getElementById("borrados");
	      descrip = document.getElementById("descBtn"); 
	      switch(borrado.style.display) {  
	         case "inline"   :  
	         case ""         :   borrado.style.display = "none";
	         					 descrip.innerHTML = "<br>Ver Borrados"; 
	                        break; 
	         case "none"      :    borrado.style.display = "";

                 descrip.innerHTML = "<br>Ocultar Borrados";
	                        break; 
	      }
	} 
}

function modificarExp(numExpediente)
{
	var anchoPantalla = screen.availWidth;
  	var altoPantalla  = screen.availHeight; 
    window.open("<?=$ruta_raiz?>/expediente/modificarExpediente.php?sessid=<?=session_id()?>&isEditMTD=1&numExpediente="+numExpediente+"&krd=<?=$krd?>","modExp","height="+altoPantalla+",width="+anchoPantalla+",scrollbars=yes");
}
function noPermiso(tip)
{
    if(tip==0)
        alert ("No tiene permiso para acceder, su nivel es inferior al del usuario actual");
    if(tip==1)
        alert ("No tiene permiso para ver la imagen, el Radicado es confidencial");
}
function solcitarPretamo(exp)
{
    var anchoPantalla = 300;
    var altoPantalla  = 300;
    var x = (screen.availWidth/2)-150
    var y = (screen.availHeight/2)-150
    window.open("<?=$ruta_raiz?>/expediente/prestamo/solicitar.php?sessid=<?=session_id()?>&expNum="+exp+"&krd=<?=$krd?>","modExp","top="+y+",left="+x+",height="+altoPantalla+",width="+anchoPantalla+",scrollbars=yes");
}
</script>
<form id="frmExp" name="frmExp" method="post" action="<?=$frmActual."?numExpediente=$numExpediente&numExpActual=$numExpediente"?>">
<table   border="0" width="100%" class="borde_tab" align="center" class="titulos2">

	<tr>
		<td colspan="8">
			<table border="0" width="100%" class="borde_tab" align="center" class="titulos2">
			<tr bordercolor="#FFFFFF">
				<td colspan="6" class="titulos2"><div align="center"><strong><br>INFORMACI&Oacute;N DEL EXPEDIENTE</strong></div>
				<?if($expediente->fase>1){?><div align="right">&nbsp;&nbsp;&nbsp;<a href="<?=$ruta_raizImg?>/expediente/prestamo/solicitar.php?sessid=<?=session_id()?>&expNum=<?=$numExpediente?>&krd=<?=$krd?>&frmAnt=<?=$frmActual?>&verrad=<?=$verrad?>">Solicitar F&iacute;sico</a>&nbsp;&nbsp;&nbsp;</div><?}?><br></td>
			</tr>
			<tr>
			    <td class="titulos2" colspan="1" width="20%"><font size="1" color="#FF0000">N&uacute;mero de Expediente:</font></td>
			    <td class="titulos5" colspan="2"><font size="1"  color="#FF0000"><?=$numExpediente?>
			    <?if(($expediente->responsable==$_SESSION['usua_doc'] && $expediente->fase<2)|| ($_SESSION["usua_admin_archivo"]>=1 and $expediente->fase>=2)){?>
			    		<input type="button" value="Modificar Datos" class=botones_mediano2 onClick="modificarExp('<?=base64_encode($numExpediente.'%')?>');">
			    <?}?>
			    </font>
                            </td>
			    <td class='titulos2' colspan="1" nowrap>Historia del Expediente: </td>
                            <td class='titulos5' colspan="2" ><input type="button" value="Ver" class=botones_2 onClick="verHistExpediente('<?=$numExpediente?>');"></td>
			</tr>
			<tr>
                            <td class="titulos2" colspan="1">Responsable:</td>
                            <td class="titulos5" colspan="2"><b><span class=leidos2><?=$expediente->responsableNom?></span></b>
                            <?if(($_SESSION['usuaPermExpediente']==2  && $expediente->depCodi==$_SESSION['dependencia']) || ($_SESSION["usua_admin_archivo"]>=1)){?>
                                    <input type='button' value='Cambiar' class='botones_3' onClick="Responsable('<?=base64_encode($numExpediente.'%')?>')">
                            <?}?>
                            </td>
                            <td class="titulos2" nowrap>Dependencia:</td>
                            <td colspan="2" class='titulos5'><b><span class=leidos2><?=$depExp; ?></span></b></td>
			</tr>
                        <tr>
			    <td class="titulos2" nowrap>Fecha Inicio:</td>
                            <td colspan="2" class='titulos5'><font class=leidos2><?=substr($expediente->fecha,0,10)?></font></td>
			    <td class='titulos2' colspan="1" nowrap>Nivel seguridad:</td>
                            <td class='titulos5' colspan="2" ><b><span class=leidos2><?=$nvExp?></span></b></td>
			</tr>
			<tr>
                            <td class='titulos2' colspan="1">Estado :</td>
                            <td class='titulos5' colspan="2"><?if($expediente->codigoFldExp){?><b><span class=leidos2><span class="leidos2"><?=$expediente->descFldExp?></span><input type="button" value="..." class=botones_2 onClick="modFlujo('<?=$numExpediente?>',<?=$expediente->codigoTipoExp?>,<?=$expediente->codigoFldExp?>)"></span></b><?}?></td>
                            <td class='titulos2' colspan="1">Adicionar Proceso :</td>
                            <td class='titulos5' colspan="2">
                            <?if(($expediente->responsable==$_SESSION['usua_doc']  && $expediente->fase<2 and $expediente->depCodi==$_SESSION['dependencia'])|| ($_SESSION["usua_admin_archivo"]>=1 and $expediente->fase>=2)){?>
                                <input type="button" value="..." class=botones_2 onClick="crearProc('<?=$numExpediente?>');">
                            <?}?>
                            </td>
			</tr>
			<tr>
			  <td class='titulos2' >TRD:</td>
			  <td colspan="2" class='titulos5'><b><span  class=leidos2><?=$trdExpediente?></span></b></td>
			  <td class="titulos2">Proceso:</td>
			  <td colspan="2" class='titulos5'><b><span class=leidos2><?=$proce?></span></b></td>
			</tr>
			<tr >
			  <td class="titulos2" nowrap><font size="1"><b>Nombre:</b></font></td>
                          <td colspan="5" class='titulos5'><font size="1" class=leidos2><b><?=$expediente->nombreExp ?></b></font></td>
			</tr>
			<tr >
			  <td class="titulos2" nowrap>Asunto:</td>
			  <td colspan="5" class='titulos5'><font class=leidos2><?=$expediente->asuntoExp ?></font></td>
			</tr>
			<tr>
			  <td class="titulos2" colspan="1"><span id='descBtn'>Ver Borrados:&nbsp;</span></td>
              <td class="titulos5" colspan="2"><input type="button" name="btnVerBorrados" id="btnVerBorrados" value="..." class="botones_2" onclick="verBorrados();"></td>
			  <td class="titulos2" colspan="1"><span id='descBtn'>Fase Expediente</span></td>
              <td class="titulos5" colspan="2"><?if($expediente->fase<2)echo "Archivo de Gesti&oacute;n"; else echo "Archivo Central";?></td>
			</tr>
			<tr>
				<td colspan="5"><br/>
<?php 
if (!($mostrar || $isEditMTD)) {
    $cnt = 0;
    $ADODB_COUNTRECS = true;
    $sql = "select m.sgd_mtd_codigo AS IDM, m.sgd_mtd_nombre AS NOMBRE, m.sgd_mtd_descrip AS DESCRIP, s.sgd_mmr_dato AS DATOS 
from sgd_mmr_matrimetaexpe s
	left join sgd_mtd_metadatos m on s.sgd_mtd_codigo = m.sgd_mtd_codigo 
where s.sgd_exp_numero = '$numExpediente'";
    $idSerie = (int) substr($numExpediente, 7, 3);
    $idSSerie= (int) substr($numExpediente, 10, 2);
    if (!empty($idSerie) && !empty($idSSerie)) {
        $sql .= " and m.sgd_srd_codigo=" . $idSerie . " and sgd_sbrd_codigo=" . $idSSerie;
        $rsmtd = $db->conn->query($sql);
        $cnt = $rsmtd->RecordCount();
    }
    $ADODB_COUNTRECS = false;
    $i = 0;
    if ($cnt > 0) {
        $tabla =
                "
	<table class=borde_tab width='100%' cellpadding='0' cellspacing='5'>
  	<tr class='titulo5' align='center'>
  		<td colspan='3' class='titulos2'>METADATOS ASOCIADOS</td>
  	</tr>";
        do {
            $tabla .=
                        "<tr>
		  	<td  class='titulos2' nowrap='nowrap' width='20%'>&nbsp;" . $rsmtd->fields['NOMBRE'] . "</td>
		  	<td class='titulos5'><font class='leidos2'>&nbsp;" . $rsmtd->fields['DATOS'] . "</font></td>
		  	</tr>";
            $i++;
            $rsmtd->MoveNext();
        } while (!$rsmtd->EOF);
        $tabla .= "</table>";
    }
    echo $tabla;
}
?>
				</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class='timparr'>
		<td colspan="6" class="titulos5">
			<?=$tablaRads?>
		</td>
	</tr>
        <?if($tblAnexAsoc){?>
	<tr class='timparr'>
		<td colspan="6" class="titulos5">
			<?=$tblAnexAsoc?>
		</td>
	</tr>
        <?}?>
</table>
</form>


