<table border=0 width="100%"  cellpad=2 cellspacing='0' class="borde_tab" valign='top' align='center' >
	<tr>
	<tr/>
	<tr><td width='100%' >
	<table align="center" cellspacing="0" cellpadding="0" width="100%" class="borde_tab">
	<tr class="tablas"><td class="etextomenu" >
	<span class="etextomenu">
	<form name=form_busq_rad action='<?=$pagina_actual?>?<?=session_name()."=".session_id()."&krd=$krd" ?>&estado_sal=<?=$estado_sal?>&tpAnulacion=<?=$tpAnulacion?>&estado_sal_max=<?=$estado_sal_max?>&pagina_sig=<?=$pagina_sig?>&dep_sel=<?=$dep_sel?>&nomcarpeta=<?=$nomcarpeta?>' method=post>
	Buscar radicado(s) (Separados por coma)
	<input name="busqRadicados" type="text" size="60" class="tex_area" value="<?=$busqRadicados?>" id="busqRadicados">
	<input type=submit value='Buscar ' name=Buscar valign='middle' class='botones'>
	<?
	if ($busqRadicados) {
		$busqRadicados = trim($busqRadicados);
		$textElements = split (",", $busqRadicados);
		$newText = "";
		$i = 0;
		foreach ($textElements as $item) {
			$item = trim ( $item );
			if ($item) { 
			if ($i != 0) $busq_and = " or "; else $busq_and = " ";
				$busq_radicados_tmp .= " $busq_and $varBuscada like '%$item%' ";
				$i++;
			}
		} //FIN foreach

	$dependencia_busq2 .= " and ($busq_radicados_tmp) ";
	} //FIN if ($busqRadicados)
?>
	</form>
	 </span>
	</td></tr>
	</table>
	<td/>
  <tr/>
</table>
