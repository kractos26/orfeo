<?php
session_start();
$ruta_raiz = "..";
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
require_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler($ruta_raiz);

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;
$depe_codi = $_SESSION['depecodi'];

require "../archivo/class_archivo.php";
$btt = new ARCHIVO_ORFEO($db);
if (isset($_GET['num_expediente']) && isset($_GET['nurad']))
{
	$btt->datos_expediente($num_expediente,$nurad);
	$num_carpetas = $btt->exp_num_carpetas;
	$exp_subexpediente= $btt->exp_subexpediente;
	$exp_caja = $btt->exp_caja;
	$exp_carpeta = $btt->exp_carpeta;
	$exp_estado = $btt->exp_estado;
	$exp_archivo = $btt->exp_archivo;
	$exp_unidad = $btt->exp_unicon;
	$exp_fechaIni = $btt->exp_fechaIni;
	$exp_fechaFin = $btt->exp_fechaFin;
	$exp_folio = $btt->exp_folio;
	$exp_retenci = $btt->exp_rete;
	$exp_entrepa= $btt->exp_entrepa;
	$exp_edificio=$btt->exp_edificio;
	$EST=$btt->exp_archivo;
	$UN=$btt->exp_unicon;
	$CD_TOL=$btt->exp_cd;
	$NREF=$btt->exp_nref;
	$farch=$btt->exp_fech_arch;
	if(($exp_caja=="" or $exp_caja==0) and $exp_entrepa!="")	$bus=$exp_entrepa;
	else $bus = $exp_caja;
	//$db->conn->Debug=true;
	$qpri=$db->conn->Execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$bus'");
	if(!$qpri->EOF)
	{	$it1=$qpri->fields['SGD_EIT_COD_PADRE'];
		$qsec=$db->conn->Execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$it1'");
		if(!$qsec->EOF)
		{	$it2=$qsec->fields['SGD_EIT_COD_PADRE'];
			$qtir=$db->conn->Execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$it2'");
			if(!$qtir->EOF)
			{	$it3=$qtir->fields['SGD_EIT_COD_PADRE'];
				$qcua=$db->conn->Execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$it3'");
				if(!$qcua->EOF)
				{	$it4=$qcua->fields['SGD_EIT_COD_PADRE'];
					$qqin=$db->conn->Execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$it4'");
					if(!$qqin->EOF)
					{	$it5=$qqin->fields['SGD_EIT_COD_PADRE'];
						$qsex=$db->conn->Execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$it5'");
						if(!$qsex->EOF)
						{	$it6=$qsex->fields['SGD_EIT_COD_PADRE'];
							$qset=$db->conn->Execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$it6'");
							if(!$qset->EOF)
							{	$it7=$qset->fields['SGD_EIT_COD_PADRE'];
	}	}	}	}	}	}	}
	if($it7 and $it7==$exp_edificio){$ite1=$it6;$ite2=$it5;$ite3=$it4;$ite4=$it3;$ite5=$it2;$ite6=$it1;}
	if($it6 and $it6==$exp_edificio){$ite1=$it5;$ite2=$it4;$ite3=$it3;$ite4=$it2;$ite5=$it1;}
	if($it5 and $it5==$exp_edificio){$ite1=$it4;$ite2=$it3;$ite3=$it2;$ite4=$it1;}		
	if($it4 and $it4==$exp_edificio){$ite1=$it3;$ite2=$it2;$ite3=$it1;}
	if($it3 and $it3==$exp_edificio){$ite1=$it2;$ite2=$it1;$ite3=$bus;}
	$ent++;
}
else die("Acceso indebido. No llegan variables");
if($exp_carpeta!="" and $car)
{
	$sqlrad4 = "select SGD_EXP_CAJA FROM SGD_EXP_EXPEDIENTE WHERE SGD_EXP_NUMERO LIKE '$num_expediente' and SGD_EXP_CARPETA LIKE '$exp_carpeta'";
	$rsrad4 = $db->query($sqlrad4);
	if(!$rsrad4->EOF)	$exp_caja=$rsrad4->fields['SGD_EXP_CAJA'];
}
?>
<html>
<head>
<title>Ubicaci&oacute;n de radicado <?=$nurad; ?>en expediente <?=$num_expediente; ?></title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body>
<table width="80%" height="99%" cellspacing="5"  align="center" class="borde_tab" >
		<tr valign="bottom" >
			<td class='titulos2'><?=$etiquetas?></td>
		</tr>
		<tr>
			<td class='titulos2'>
				SUBEXPEDIENTE
				<input type=text class='tex_area' name="exp_subexpediente" id="exp_subexpediente" value='<?=$exp_subexpediente?>' size=3 maxlength="2"><BR>
			</td>
		</tr>
		<!-- 
		<TR>
			<TD colspan="3" align="center" class='titulos2' height="30"><b>Folio
			<?=$exp_carpeta?> de <?=$num_carpetas?></b>
			</TD>
		</TR>
		-->
		<tr class='titulos2'>
			<td colspan="3">
<?php // parametrizacion de items
		$sql="select SGD_EIT_NOMBRE, SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = '0'";
		$rs=$db->query($sql);
		$item1=$rs->fields["SGD_EIT_NOMBRE"];
		$cod1=$rs->fields["SGD_EIT_CODIGO"];
?>
				<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" class="borde_tab"  >
				<tr class='titulos2'><TD>&nbsp;</TD></TR>
				<!-- 
				<tr valign="bottom" class='titulos2'>
					<td class="titulos2">DEPARTAMENTO
					<td class="titulos2" >
<?php
//$db->conn->debug=true;
//			if ($codDpto!="")$codDpto2=$codDpto;
//			$queryDpto = "select distinct(d.dpto_nomb),d.dpto_codi from departamento d, sgd_eit_items i where d.dpto_codi=i.codi_dpto ORDER BY dpto_nomb";
//			$rsD=$db->query($queryDpto);
//			print $rsD->GetMenu2("codDpto2", $codDpto2, "0:-- Seleccione --", false,""," onChange='submit()' class='select'" ); //echo "D.C.";//PARA LA CRA
?>
					</td>
					<td class="titulos2">MUNICIPIO</td>
					<td class="titulos2">
<?php 
//if( !isset( $codDpto2 ) )
//{
//	$codDpto2 = 0;
//}
//			if ($codMuni!="")$codMuni2=$codMuni;
// 			$queryMuni = "select distinct(m.MUNI_NOMB),m.MUNI_CODI FROM MUNICIPIO m , SGD_EIT_ITEMS i WHERE m.MUNI_CODI=i.CODI_MUNI and DPTO_CODI='$codDpto2' ORDER BY MUNI_NOMB";
// 			$rsm=$db->query($queryMuni);
// 			print $rsm->GetMenu2("codMuni2", $codMuni2, "0:-- Seleccione --", false,""," onChange='submit()' class='select'" );//echo "BOGOTA";//PARA LA CRA
?>
					</td>
				</tr>
				-->
				<tr class="titulos2">
					<td class='titulos2'>EDIFICIO </td>
					<td>
<?php 
		$ver=1;
		if ($exp_edificio!="" and $exp_edificio2=="")$exp_edificio2=$exp_edificio;
		$rsv=$db->conn->Execute("select sgd_arch_edificio as SGD_ARCH_EDIFICIO from sgd_arch_depe where sgd_arch_depe = $depe_codi");
		while(!$rsv->EOF)
		{
			$edif=$rsv->fields['SGD_ARCH_EDIFICIO'];
			if(($edif!="" and $edif==$exp_edificio) or $exp_edificio=="") $ver++;
			$rsv->MoveNext();
		}
		if($ver!=1)
		{	$perm_mod=2;	}
		else
		{	$perm_mod=1;
?>
					<script language="javascript">
					confirm('No tiene permiso para modificar esta ubicacion');
					</script>
<?php 
		}
		$sql="select distinct(SGD_EIT_NOMBRE),SGD_EIT_CODIGO from SGD_EIT_ITEMS, SGD_ARCH_DEPE where sgd_eit_cod_padre=0 and SGD_ARCH_DEPE='$depe_codi' and SGD_EIT_CODIGO=SGD_ARCH_EDIFICIO";
		$rs=$db->query($sql);
		print $rs->GetMenu2('exp_edificio2',$exp_edificio2,true,false,""," onChange='submit()' class=select"); ///echo "CRA";//PARA LA CRA
?>
					</td>
<?php
		$sql="select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = '$exp_edificio2' order by SGD_EIT_NOMBRE ";
		$rs=$db->query($sql);
		if (!$rs->EOF)	$item21=$rs->fields["SGD_EIT_NOMBRE"];
		$item2=explode(' ',$item21);
?>
					<td class='titulos2'><?=$item2[0] ?></td>
					<td>
<?php 
		$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS";
		$ver2=1;
		if ($ent==2)$exp_piso2=$ite1;
		$sqpd="select sgd_arch_item from sgd_arch_depe where sgd_arch_depe = $depe_codi ";
		if($exp_edificio2!="")$sqpd.= " and sgd_arch_edificio = $exp_edificio2";
		$rsv2=$db->conn->Execute($sqpd);
		while(!$rsv2->EOF)
		{
			$item1=$rsv2->fields['SGD_ARCH_ITEM'];
			if(($edif!="" and $item1==$ite1) or $item1==0 or $ite1=="")
			{
				$ver2++;
			}
			$rsv2->MoveNext();
		}
		if($ver2!=1)
		{	$perm_mod=2;	}
		else
		{
			$perm_mod=1;
?>
					<script language="javascript">
						confirm('No tiene permiso para modificar esta ubicacion');
					</script>
<?php 
		}
		if($item1!=0)$sql.=", SGD_ARCH_DEPE";
		$sql.=" where SGD_EIT_COD_PADRE = $exp_edificio2";
		if($item1!=0)$sql.=" and SGD_ARCH_DEPE='$depe_codi' and SGD_EIT_CODIGO=SGD_ARCH_ITEM ";
		$sql.="order by SGD_EIT_NOMBRE";
		$rs=$db->query($sql);
		print $rs->GetMenu2('exp_piso2',$exp_piso2,true,false,""," onChange='submit()' class=select");
		/*/$exp_piso2=3; 
		echo "PISO 6";//para la cra*/
?>
					</td>
				</tr>
				<tr class='titulos2'>
<?php
		$sql = "select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_piso2 order by SGD_EIT_NOMBRE ";
		$rs = $db->query($sql);
		if (!$rs->EOF)	$item31=$rs->fields["SGD_EIT_NOMBRE"];
		$item3=explode(' ',$item31);
		if($item3[0]!="")
		{
?>
					<td class='titulos2'><?=$item3[0]?></td>
					<td>
<?php
			//if ($exp_item1!="" and $exp_item12==""){
			if($ent==2)
			{
				$exp_item12=$ite2;
			}
			$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_piso2 order by SGD_EIT_NOMBRE";
			$rs=$db->query($sql);
			print $rs->GetMenu2('exp_item12',$exp_item12,true,false,""," onChange='submit()' class=select");
?>
					</td>
<?php
		}
		$sql="select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_item12 order by SGD_EIT_NOMBRE";
		$rs=$db->query($sql);
		if (!$rs->EOF)$item41=$rs->fields["SGD_EIT_NOMBRE"];
		$item4=explode(' ',$item41);
		if($item4[0]!="")
		{
?>
					<td class='titulos2'><?=$item4[0]?></td>
					<td>
<?php
			if ($exp_item22=="" or $ent==2)
			{	$exp_item22=$ite3;	}
			$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_item12 order by SGD_EIT_NOMBRE";
			$rs=$db->query($sql);
			print $rs->GetMenu2('exp_item22',$exp_item22,true,false,""," onChange='submit()' class=select");
?>
					</td>
				</tr>
<?php
		}
		$sql="select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_item22 order by SGD_EIT_NOMBRE";
		$rs=$db->query($sql);
		if (!$rs->EOF)$item51=$rs->fields["SGD_EIT_NOMBRE"];
		$item5=explode(' ',$item51);
?>
				<tr>
<?php
		if($item5[0]!="")
		{
?>
					<td class='titulos2'><?=$item5[0]?></td>
					<td>
<?php
			if($exp_item31=="" or $ent==2)
			{
				if($ite4)$exp_item31=$ite4;
				else $exp_item31=$bus;
			}
			$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_item22 order by SGD_EIT_NOMBRE";
			$rs=$db->query($sql);
			print $rs->GetMenu2('exp_item31',$exp_item31,true,false,""," onChange='submit()' class=select");
?>
					</td>
<?php
		}
		$sql="select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_item31 order by SGD_EIT_NOMBRE";
		$rs=$db->query($sql);
		if (!$rs->EOF)$item61=$rs->fields["SGD_EIT_NOMBRE"];
		$item6=explode(' ',$item61);
		if($item6[0]!="")
		{
?>
					<td class="titulos2" ><?=$item6[0]?></td>
					<td>
<?php
			if($exp_entre=="" or $ent==2)
			{
				if($ite5)$exp_entre=$ite5;
				else $exp_entre=$bus;
			}
			$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_item31 order by SGD_EIT_NOMBRE";
			$rs=$db->query($sql);
			print $rs->GetMenu2('exp_entre',$exp_entre,true,false,"","onChange='submit()'  class=select");
?>
					</td>
<?php
		}
		$sql="select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_entre order by SGD_EIT_NOMBRE";
		$rs=$db->query($sql);
		if (!$rs->EOF)$item71=$rs->fields["SGD_EIT_NOMBRE"];
		$item7=explode(' ',$item71);
?>
				</tr>
				<tr>
<?php
		if($item7[0]!="")
		{
?>
					<td class='titulos2' ><?=$item7[0]?> </td>
					<td>
<?php
			if($exp_caja2=="" or $ent==2)
			{
				if($ite6)$exp_caja2=$ite6;
				else $exp_caja2=$bus;
			}
			$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_entre order by SGD_EIT_NOMBRE";
			$rs=$db->query($sql);
			print $rs->GetMenu2('exp_caja2',$exp_caja2,true,false,"","onChange='submit()' class=select");
?>
</td>
<?php
		}
		$sql="select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_caja2 order by SGD_EIT_NOMBRE";
		$rs=$db->query($sql);
		if (!$rs->EOF)$item81=$rs->fields["SGD_EIT_NOMBRE"];
		$item8=explode(' ',$item81);
		if($item8[0]!="")
		{
?>
					<td class='titulos2' ><?=$item8[0]?> </td>
					<td>
<?php
			if($exp_caja3=="" or $ent==2)
			{
				$exp_caja3=$bus;
			}
			$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = $exp_caja2 order by SGD_EIT_NOMBRE";
			$rs=$db->query($sql);
			print $rs->GetMenu2('exp_caja3',$exp_caja3,true,false,"","onChange='submit()' class=select");
?>
					</td>
<?php
		}
		if(($exp_caja2!="" or $exp_caja3!="") and $NREF=="")
		{
			if($exp_caja2!="")$qlp="select sgd_exp_nref from sgd_exp_expediente where sgd_exp_entrepa = $exp_caja2 or sgd_exp_caja =$exp_caja2";
			else $qlp="select sgd_exp_nref from sgd_exp_expediente where sgd_exp_caja =$exp_caja3";
			//$db->conn->debug=true;
			$rslp=$db->conn->Execute($qlp);
			if(!$rslp->EOF)
			{	$NREF=$rslp->fields['SGD_EXP_NREF'];	}
		}
		//			*Modificado por Fabian Mauricio Losada
?>
				</tr>
				<tr>
					<td class='titulos2' >NRO REFERENCIA </td>
					<td><input type="text" maxlength="5" size="6" class="titulos2" name="NREF" value="<?=$NREF?>"> </td>
				</tr>
<?php
		if(!$exp_fechaIni) $exp_fechaIni = date("Y-m-d");
?>
				<tr class='titulos2'>
					<td width="20%" class='titulos2' >Fecha Inicial </td>
					<td width="25%" >
						<script language="javascript">
							var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "form1", "exp_fechaIni","btnDate1","<?=$exp_fechaIni?>",scBTNMODE_CUSTOMBLUE);
							dateAvailable1.date = "<?=date('Y-m-d');?>";
							dateAvailable1.writeControl();
							dateAvailable1.dateFormat="yyyy-MM-dd";
						</script>
					</td>
<?php
		if($EST==2 or $exp_fechaFin!="")
		{
?>
					<td width="20%" class='titulos2' >Fecha Final&nbsp;&nbsp;&nbsp;</td>
   					<td width="30%" >
   						<script language="javascript">
   						var dateAvailable3 = new ctlSpiffyCalendarBox("dateAvailable3", "form1", "exp_fechaFin","btnDate1","<?=$exp_fechaFin?>",scBTNMODE_CUSTOMBLUE);
  						dateAvailable3.date = "<?=date('Y-m-d');?>";
						dateAvailable3.writeControl();
						dateAvailable3.dateFormat="yyyy-MM-dd";
						</script>
<?php
}
?>
					&nbsp;
					</td>
				</tr>
				<tr>
<?php
			$sqlrad="select e.RADI_NUME_RADI,e.SGD_EXP_ESTADO,r.RADI_NUME_HOJA,r.MEDIO_M FROM SGD_EXP_EXPEDIENTE e, RADICADO r WHERE SGD_EXP_NUMERO LIKE '$num_expediente' and r.RADI_NUME_RADI=e.RADI_NUME_RADI and e.sgd_exp_estado !=2";
			if($exp_carpeta!="" and $car)$sqlrad.=" and e.SGD_EXP_CARPETA LIKE '$exp_carpeta'";
			if($exp_carpeta=="")$sqlrad.=" and e.SGD_EXP_CARPETA IS NULL";					
			$sqlrad.=" ORDER BY e.RADI_NUME_RADI";
			$rsrad=$db->conn->Execute($sqlrad);
			$j=1;
			$exp_folio=0;
			$CD_TOL=0;
			while(!$rsrad->EOF)
			{
				$fol[$j]=$rsrad->fields['RADI_NUME_HOJA'];
				$esta[$j]=$rsrad->fields['SGD_EXP_ESTADO'];
				$CD[$j]=$rsrad->fields['MEDIO_M'];
				if($esta[$j]==1)
				{
					$exp_folio+=$fol[$j];
					$CD_TOL+=$CD[$j];
				}
				$rsrad->MoveNext();
				$j++;
			}
			/*
			if($exp_folio>=$CARPETA)
			{	
				echo "<script language='javascript'>confirm('Debe hacer el cambio de carpeta');</script>";
			}
			*/
?>
					<td align="right" class='titulos2'>FOLIOS TOTAL:&nbsp; </td>
					<td align="left" class='titulos2'><?=$exp_folio; ?></td>
					<td align="right" class='titulos2'>ANEXOS TOTAL:&nbsp; </td>
					<td align="left" class='titulos2'>
						<?=$CD_TOL; ?>
						<input type="hidden" name="efolio" value=<?=$exp_folio; ?>
						<input type="hidden" name="eanexo" value=<?=$CD_TOL; ?>
					</td>
				</tr>
<?php 
$sqlfase="select sgd_sexp_faseexp from sgd_sexp_secexpedientes where sgd_exp_numero='".$num_expediente."'";
$rsfase=$db->conn->Execute($sqlfase);
$fase=$rsfase->fields['SGD_SEXP_FASEEXP'];
?>
				<tr><td class='titulos2'colspan="4" align="center">FASE EXPEDIENTE :<?php if($fase < 2){echo " Archivo de Gesti&oacute;n";} else{echo " Archivo Central";}?></td></tr>
				
				<tr><td class='titulos2'colspan="4" align="center">UNIDAD DE CONSERVACION :</td></tr>
				<tr>
					<td class='titulos2'colspan="4" align="center">CAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
			if($UN == 1 ) $datoss = "checked"; else $datoss= "";
?>
						<input name="UN" type="radio" class="select" value="1" <?=$datoss?>>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AZ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
			if($UN == 2) $datoss = "checked"; else $datoss= "";
?>
 						<input name="UN" type="radio" class="select" value="2" <?=$datoss?>>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LB &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
			if($UN == 3 ) $datoss = "checked"; else $datoss= "";
?>
		 				<input name="UN" type="radio" class="select" value="3" <?=$datoss?>>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
			if($UN == 4 ) $datoss = "checked"; else $datoss= "";
?>
	 					<input name="UN" type="radio" class="select" value="4" <?=$datoss?>>
	 				</td>
		 		</tr>
<?php
			$querycar="select max(cast(sgd_exp_carpeta as int)) as MAXI from sgd_exp_expediente where sgd_exp_numero like '$num_expediente'";
			$rscar=$db->conn->Execute($querycar);
			$carpetamax=$rscar->fields['MAXI'];
?>
	 			<tr>
	 				<td class="titulos2" align="center" colspan="4"> 
	 					No:<input type="text" name="exp_carpeta" value="<?=$exp_carpeta?>" size="3" maxlength="2" > DE <?=$carpetamax?>&nbsp;&nbsp;&nbsp;
						<input type="submit" name="car" value=">>" class="botones_2">
					</td>
	 			</tr>
					<input type="hidden" name="exp_carpeta2" value="<?=$exp_carpeta?>">
<?php
			$exp_carpeta2=$exp_carpeta;
			$sqlrad1="select e.RADI_NUME_RADI,e.SGD_EXP_ESTADO,r.RADI_NUME_HOJA FROM SGD_EXP_EXPEDIENTE e, RADICADO r WHERE SGD_EXP_NUMERO LIKE '$num_expediente' and r.RADI_NUME_RADI=e.RADI_NUME_RADI and e.sgd_exp_estado !=2";
			if($exp_carpeta!="" and $car)$sqlrad1.=" and e.SGD_EXP_CARPETA LIKE '$exp_carpeta'";
			if($exp_carpeta=="")$sqlrad1.=" and e.SGD_EXP_CARPETA IS NULL";
			$sqlrad1.=" ORDER BY e.RADI_NUME_RADI";
			//$db->conn->debug=true;
			$rsrad=$db->query($sqlrad1);
			$ce=1;
			while(!$rsrad->EOF)
			{
				$arrayRad[$ce]=$rsrad->fields['RADI_NUME_RADI'];
				$rsrad->MoveNext();
				$ce++;
			}
?>
	 			<tr>
	 				<td class='titulos2' align="center" colspan="4">ESTOS SON LOS RADICADOS INCLUIDOS EN ESTE EXPEDIENTE:</td>
	 			</tr>
				<tr>
					<td class='titulos2' align="center" colspan="2">Radicado</td>
					<td class='titulos2' align="center" >Folios </td>
					<td class='titulos2' align="center" >Anexos </td>
					<td class='titulos2' align="center" >Incluir </td>
				</tr>
<?php
			$p=3;
			for($t=1;$t<$ce;$t++)
			{
?>
				<tr>
					<td class='titulos2' align="center" colspan="2"><?=$arrayRad[$t]?></td>
<?php
				if ($esta[$t]=='1' or $arrayRad[$t]==$nurad) $st="checked"; else $st="";
				if($fol[$t]=="")$fol[$t]=0;
				if($CD[$t]=="")$CD[$t]=0;
?>
					<td class='titulos2' align="center" ><input type="text" class="titulos2" value="<?=$fol[$t]?>" name="fol[<?=$t?>]" maxlength="4" size="5"></td>
					<td class='titulos2' align="center" ><input type="text" class="titulos2" value="<?=$CD[$t]?>" name="CD[<?=$t?>]" maxlength="4" size="5"></td>
					<td class='titulos2' align="center" ><input name="inclu[<?=$t?>]" type="checkbox" class="select" value="<?=$p?>" <?=$st?>>
				</tr>
<?php
				$arrayRad3[$t]=$arrayRad[$t];
				$p++;
			}
?>
	 			<tr><td>&nbsp;</td></tr>
				<tr>
<?php
			if(($exp_estado==0 or $permiso>=1) and $perm_mod==2)
			{
?>
					<td colspan="2" align="right"><input type="submit" value="Archivar" name="Archivar" class="botones">&nbsp;</td>
<?php
				if($Grabar)
				{	$exp_archivo=$EST;
					$exp_unidad=$UN;$exp_rete=$exp_retenci;
					$arrayRad3=$arrayRad;
				}
			}
	?>				<BR>
	                <td colspan="2" align="left"><a href="../expediente/cuerpo_exp.php?<?=session_name()?>=<?=session_id()?>&krd=<?=$krd?>&fechah=<?=$fechah?>&nurad=<?=$nurad?>&num_expediente=<?=$num_expediente?>"><input type="button" value="Regresar" name="regresar" class="botones"></a></td>
				</tr>
				<tr><td colspan="4"></td></tr>
				<tr class='titulos2'><td colspan="4"></td></tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="4"></td></tr>
		</table>
</body>
</html>