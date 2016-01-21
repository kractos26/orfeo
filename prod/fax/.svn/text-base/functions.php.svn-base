<?php
	function add_ticket($var_filename,$number,$dest,$text)
{
	error_reporting(7);
		$fax_tmp = "/tmp/fax.png";
		error_reporting(7);
		unset($exec_output);
		unset($exec_return);
		if(file_exists($var_filename))
		{
			exec("/usr/bin/convert  $var_filename $fax_tmp",$exec_output,$exec_return);
		}
		
		if(file_exists($fax_tmp))
		{
			$files .= $fax_tmp." ";
			$image = imagecreatefrompng($fax_tmp);
			$negro = imagecolorallocate($image,0,0,0);
			$x=imagesx($image);
			imagerectangle($image,$x/2-5,90,$x/2+240,170,$negro);
			imagestring($image,5,$x/2,100,"SSPD Rad No. $number",$negro);
			imagestring($image,5,$x/2,120,$text,$negro);
			imagestring($image,5,$x/2,140,"Gestion Documental Orfeo",$negro);
			imagepng($image,$fax_tmp);
			imagedestroy($image);
		}
		else 
		{
			$i = 0;
			while(file_exists($fax_tmp.".$i"))
			{
				$image = imagecreatefrompng($fax_tmp.".$i");
				$negro = imagecolorallocate($image,0,0,0);
				$x=imagesx($image);
				imagerectangle($image,$x/2-5,90,$x/2+240,170,$negro);
				imagestring($image,5,$x/2,100,"SSPD Rad No. $number",$negro);
				imagestring($image,5,$x/2,120,"$text",$negro);
				imagestring($image,5,$x/2,140,"Gestion Documental Orfeo",$negro);
				imagepng($image,$fax_tmp.".$i");	
				$files .= $fax_tmp.".$i ";
				$i++;
				imagedestroy($image);
			}
		}
		
		
		unset($exec_output);
		unset($exec_return);
		
		exec("/usr/bin/convert -adjoin $files $dest",$exec_output,$exec_return);

		
		if(file_exists($fax_tmp))
		{
			exec("rm -rf $fax_tmp");
		}
		else
		{
			$i = 0;
			while(file_exists($fax_tmp.".$i"))
			{
				exec("rm -rf $fax_tmp".".$i");
				$i++;
			}
			
		}
}
	function doneq_list()
	{

		$OUTPUT_REGEXP = "^\|[0-9]";
		unset($exec_output);
		unset($exec_return);
		$sshExec = "ssh -l orfeo 172.16.1.168 /usr/bin/faxstat -d | sort -t'|' +1n";
		exec($sshExec,$exec_output,$exec_return);
		//exec("/usr/bin/faxstat -d | sort -t'|' +1n",$exec_output,$exec_return);
		$no_queue = 0;
		print("<table class=borde_tab  align=\"center\" width='100%'>");
		print("<TR class=titulos5><TD><CENTER>FAXES ENVIADOS</TD></TR>");
		print("</table>");
		print("<table class=borde_tab  align=\"center\" width='100%'>");
		print("<td class=titulos5><label>FAX ID</label></td>");
		print("<td class=titulos5><label>Estado</label></td>");
		print("<td class=titulos5><label>Remitente</label></td>");
		print("<td class=titulos5><label>N&uacute;mero</label></td>");
		print("<td class=titulos5><label>Destinatario</label></td>");
		print("<td class=titulos5><label>P&aacute;ginas</label></td>");
		print("<td class=titulos5> <label>Marcaciones</label></td>");
		print("<td class=titulos5><label>Hora</label></td>");
		print("<td class=titulos5><label>Estado</label></td>");
		print("<td class=titulos5><label>Acci&oacute;n</label></td>");
		print("</tr>");
		
	for ($i=0; $i < count($exec_output); $i++) {
    	if ( ereg($OUTPUT_REGEXP,$exec_output[$i]) ) {
        	print "       <tr align=\"center\" class=listado2>\n";
        	$dsp_line = explode("|", $exec_output[$i]);

        	$dsp_jid    = $dsp_line["1"];
        	$dsp_state  = $dsp_line["2"];
        	$dsp_sender = $dsp_line["3"];
        	$dsp_number = $dsp_line["4"];
        	$dsp_destin = $dsp_line["9"];
			$dsp_pages  = $dsp_line["5"];
        	$dsp_dials  = $dsp_line["6"];
        	$dsp_tts    =$dsp_lsftp["7"];
        	if ($dsp_tts == "") {
            	$dsp_tts = "-";
        	}

        	$dsp_status = $dsp_line["8"];
        	if ($dsp_status == "") {
            	$dsp_status = "-";
        	}

        	print "        <td  class=celdaGris>\n";
        	print "         $dsp_jid\n";
        	print "        </td  class=celdaGris>\n";
        	print "        <td>\n";
        	print "         $dsp_state\n";
        	print "        </td>\n";
        	print "        <td>\n";
        	print "         $dsp_sender\n";
        	print "        </td>\n";
        	print "        <td>\n";
        	print "         $dsp_number\n";
        	print "        </td>\n";
        	print "        <td>\n";
			print "         $dsp_destin\n";
        	print "        </td>\n";
        	print "        <td>\n";
        	print "         $dsp_pages\n";
        	print "        </td>\n";
        	print "        <td>\n";
        	print "         $dsp_dials\n";
        	print "        </td>\n";
        	print "        <td>\n";
        	print "         $dsp_tts\n";
        	print "        </td>\n";
        	print "        <td>\n";
        	print "         $dsp_status\n";
        	print "        </td>\n";
        	print "        <td>\n";
        	print "        <a href=\"http://172.16.1.168/fax/viewdq.php?var_jid=" . $dsp_jid . "\">Ver</a>\n";
        	print "        <a href=\"deldq.php?var_jid=" . $dsp_jid . "\">/Borrar</a>\n";
        	print "        </td>\n";
        	print "       </tr>\n";
        	$no_queue++;
    }
}
    print("</tbody></table>");
}
	function sendq_list()
	{
		$OUTPUT_REGEXP = "^\|[0-9]";
		print("<table class=borde_tab  align=\"center\" width='100%'>");
		print("<TR class=titulos5><TD><CENTER>FAXES ENPROCESO DE ENVIO</TD></TR>");
		print("</table>");
		print("<table class=borde_tab  align=\"center\" width='100%'><TR class=titulos5>");
		print("<td class=titulos5><label>FAX ID</label></td>");
		print("<td class=titulos5><label>Estado</label></td>");
		print("<td class=titulos5><label>Destinatario</label></td>");
		print("<td class=titulos5><label>Remitente</label></td>");
		print("<td class=titulos5><label>N&uacute;mero</label></td>");
		print("<td class=titulos5><label>P&aacute;ginas</label></td>");
		print("<td class=titulos5><label>Marcaciones</label></td>");
		print("<td class=titulos5><label>Hora</label></td>");
		print("<td class=titulos5><label>Estados</label></td>");
		print("<td class=titulos5><label>Acci&oacute;n</label></td></tr>");
  		print("<tbody>");
		unset($exec_output);
		unset($exec_return);
		exec("ssh -l orfeo 172.16.1.168 /usr/bin/faxstat -s | sort",$exec_output,$exec_return);
		$no_queue = 0;
	for ($i=0; $i < count($exec_output); $i++) {
    	if ( ereg($OUTPUT_REGEXP,$exec_output[$i]) ) {
        print "       <tr align=\"center\"  class=listado2>\n";
        $dsp_line = explode("|", $exec_output[$i]);
		$dsp_jid    = $dsp_line["1"];
        $dsp_state  = $dsp_line["2"];
        $dsp_sender = $dsp_line["3"];
        $dsp_number = $dsp_line["4"];
        $dsp_pages  = $dsp_line["5"];
        $dsp_dials  = $dsp_line["6"];
        $dsp_tts    = $dsp_line["7"];
        $dsp_destin = $dsp_line["9"];
        if ($dsp_tts == "") {
            $dsp_tts = "-";
        }

        $dsp_status = $dsp_line["8"];
        if ($dsp_status == "") {
            $dsp_status = "-";
        }

        print "        <td>\n";
        print "         $dsp_jid\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_state\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_destin\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_sender\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_number\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_pages\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_dials\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_tts\n";
        print "        </td>\n";
        print "        <td>\n";
        print "         $dsp_status\n";
        print "        </td>\n";
        print "        <td>\n";
		print "        &nbsp;<a href=\"killq.php?var_jid=" . $dsp_jid . "\">Eliminar</a>\n";
        print "        </td>\n";        
        print "       </tr>\n";

        $no_queue++;
    }
}
	print("</tbody>");
	print("</table>");
	}
	function inbox_num()
	{
		exec("ssh -l orfeo 172.16.1.168 /usr/bin/faxstat -r | wc -l ",$exec_output,$exec_return);
		if($exec_output[0] > 0)
		{
			return $exec_output[0]-7;
		}
		else
		{
			return 0;
		}
	}
	function recvq_list()
	{
		global $krd;
		global $vars;
		global $db;
		global $radSel;
		$OUTPUT_REGEXP = "^\|fax";
		$fechah = date("Ymd_his");
		echo "<script>
		function verPdf(imagen,noTiff)
		{
			document.getElementById(noTiff).className='tSel';
			parent.image.location.href='image.php?var_filename='+imagen;
			parent.formulario.location.href='form.php?lista=inbox&".session_name()."=".session_id()."&krd=$krd&fechah=$fechah&primera=1&ent=2&radSel='+noTiff+'&pp=99';
			noTiffOld = noTiff;
		}
		</script>";
		
		print("<table width=\"100%\"  class=borde_tab cellpadding=2 cellspacing=2 border=0>");
		print("<tr class=titulos3><td>FAX RECIBIDOS ($radSel)</td></tr>");
		print("</table>");
		print("<table width=\"100%\"  class=borde_tab cellpadding=2 cellspacing=2 border=0>");
		print("<td  class=titulos5>Archivo:</td>");
		print("<td  class=titulos5>Fecha:</td>");
		print("<td  class=titulos5>Duraci&oacute;n:</td>");
		print("<td  class=titulos5>Remitente:</td>");
		print("<td class=titulos5>P&aacute;ginas:</td>");
		print("<td class=titulos5>Acci&oacute;n:</td>");
		print("<td class=titulos5>Reserva</td></tr>");
  		print("<tbody>");
		exec("ssh -l orfeo 172.16.1.168 /usr/bin/faxstat -r | sort",$exec_output,$exec_return);         
		$iClass = 2;
		for ($i=0; $i < count($exec_output); $i++) {
			if($iClass == 1) $tClass = "listado1 "; else $tClass = "listado2 ";

			if($iClass == 1) $iClass =2; else $iClass =1;
			
    	if ( ereg($OUTPUT_REGEXP,$exec_output[$i]) ) {
        $dsp_line = explode("|", $exec_output[$i]);
        $dsp_filename = ereg_replace("\.tif",".$RECVQ_FORMAT",$dsp_line["1"]);
        $dsp_time     = $dsp_line["2"];
        $dsp_duration = $dsp_line["3"];
        $dsp_sender   = $dsp_line["4"];
        $dsp_pages    = $dsp_line["5"];
		$noTiff = substr($dsp_filename,0,12);
		if($radSel == $noTiff) $tClass = "tSel ";
        if ($dsp_sender == "") { 
            $dsp_sender = "-";
        }
					$iSql= " SELECT
							USUA_LOGIN
							,TO_CHAR(SGD_RFAX_FECH, 'YYYY-MM-DD hh24:mi:ss') SGD_RFAX_FECH
						FROM  SGD_RFAX_RESERVAFAX
						WHERE
						SGD_RFAX_FAX='$dsp_filename"."tif'
						ORDER BY SGD_RFAX_FECH DESC
				";
				$rs = $db->conn->query($iSql);
				$usuaLogin = $rs->fields("USUA_LOGIN");
				$reservaFech = $rs->fields("SGD_RFAX_FECH");
				$fecha = (substr($dsp_time,0,11)); 
				$hora = (substr($dsp_time,11,2) - 5);
				$time = substr($dsp_time,13,9) ;
				$horaAdaptada = "$fecha  ($hora$time)";
        print "       <tr ID='$noTiff' class=$tClass>\n";
        print "        <td class=$tClass>\n<span class=leidos>";
        print "$dsp_filename\n ";
        print "        </span></td>\n";
        print "        <td class=$tClass>\n<span class=leidos>";
        print "$horaAdaptada";
        print "        </span></td>\n";
        print "        <td class=$tClass>\n<span class=leidos>";
        print "$dsp_duration\n";
        print "        </span></td>\n";
        print "        <td class=$tClass>\n<span class=leidos>";
        print "$dsp_sender\n";
        print "        </span></td>\n";
        print "        <td class=$tClass>\n<span class=leidos>";
        print "$dsp_pages\n";
        print "        </span></td>\n";
        print "        <td class=$tClass>\n<span class=leidos>";
        print "<a  href='#' onClick='verPdf(".chr(34)."$dsp_filename".chr(34).",".chr(34).$noTiff.chr(34).");'>Ver Pdf</a>/";
				if(file_exists("../bodega/faxtmp/$dsp_filename"."tif") OR ($radSel == $noTiff))
		    {
				print "<a href=\"../radicacion/chequear.php?faxPath=$dsp_filename"."tif"."&$vars\">Radicar </a>/<a target=image href=../bodega/faxtmp/" . $dsp_filename . "tif><span class=leidos>Ver tif</a>/";

				}else
				{
				print "/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/";
				}
				print "<a target=image href='borrarFax.php?faxBorrar=".$dsp_filename."&krd=$krd'>Borrar</a>/</td>\n";
        print "<td class=$tClass>\n<span class=leidos></span>$usuaLogin - $reservaFech</td>\n";
        print "</tr>\n";

        $no_queue++;
    }
}
		print("</tbody>");
		print("</table>");



	}

function faxStat_list()
	{
		global $vars;
		$OUTPUT_REGEXP = "^\|fax";
		print("<table width=\"100%\"  class=t_bordeGris>");
		print("<thead><caption></caption><tr class=t_bordeGris>");
		print("<td  class=titulos5 align=center><span class=etitulo><label><b>Estado de los Modem (<font color=red>".date("Y-m-d H:i:s")."</font>)</b></td>");
		print("</tr>");
  		print("<tbody>");
		exec("ssh -l orfeo 172.16.1.168 /usr/bin/faxstat -d | grep -v '|'",$exec_output,$exec_return);         
		
		$iClass = 2;
		//Answering the phone
		//Receiving facsimile
		foreach ($exec_output as $key => $a) {
			$a = str_replace("Running and idle","Encendido (<font color=green>Ok</font>) y Esperando Fax.
 ",$a);
			$a = str_replace("Answering the phone","Respondiendo el telefono . . .",$a);
		$a = str_replace("Receiving facsimile","<font color=green>Recibiendo Fax . . .</font>",$a);
		$a = str_replace("HylaFAX scheduler on","<center><b>SISTEMA DE CONTROL DE FAX-ORFEO EJECUTANDOSE SOBRE </b>",$a);
		$a = str_replace(": Running","<font color=green>:FUNCIONADO OK</font>",$a);
			if($iClass == 1) $tClass = " class=tparr "; else $tClass = " class=timparr ";
			if($iClass == 1) $iClass =2; else $iClass =1;
			
        print "       <tr >\n";
        print "        <td $tClass>\n<span class=$tClass>";
        print "$a\n";
        print "        </span></td>\n";
        print "       </tr>\n";

	}
		print("</tbody>");
		print("</table>");
	}

	function recvq_list_historico()
	{
		global $krd;
		global $vars;
		global $db;
		$OUTPUT_REGEXP = "^\|fax";
		print("<table width=100%  class=borde_tab>");
		print("<tr class=titulos5><td><CENTER>HISTORICO DE ARCHIVOS RECIBIDOS POR FAX</CENTER></td></tr>");
		print("</table>");
		print("<table width=\"100%\"  class=borde_tab>");
		print("<tr class=titulos5><td  class=titulos5>Archivo:</td>");
		print("<td class=titulos5>Acci&oacute;n:</td>");
		print("<td class=titulos5>Reserva</td>");
		print("<td class=titulos5>Radicado</td>");
		print("<td class=titulos5>Observaciones</td></tr>");
		exec("ls -t ../bodega/faxtmp/*tif",$exec_output,$exec_return);         
		$iClass = 2;
		for ($i=0; $i < count($exec_output); $i++) {
			if($iClass == 1) $tClass = " class=listado1 "; else $tClass = " class=listado2 ";
			if($iClass == 1) $iClass =2; else $iClass =1;
			
    	//if ( ereg($OUTPUT_REGEXP,$exec_output[$i]) ) {
			if(!$exec_return){
        $dsp_line = explode(" ", $exec_output[$i]);
        $dsp_filename = substr(ereg_replace("\.tif",".$RECVQ_FORMAT",$dsp_line["0"]),-13);
        $dsp_time     = $dsp_line["2"];
        $dsp_duration = $dsp_line["3"];
        $dsp_sender   = $dsp_line["4"];
        if ($dsp_sender == "") { 
            $dsp_sender = "-";
        }
					$iSql= " SELECT
							USUA_LOGIN
							,TO_CHAR(SGD_RFAX_FECH, 'YYYY-MM-DD hh24:mi:ss') SGD_RFAX_FECH
							,TO_CHAR(SGD_RFAX_FECHRADI, 'YYYY-MM-DD hh24:mi:ss') SGD_RFAX_FECHRADI
							,RADI_NUME_RADI
							,SGD_RFAX_OBSERVA 
						FROM  SGD_RFAX_RESERVAFAX
						WHERE
						SGD_RFAX_FAX='$dsp_filename"."tif'
						ORDER BY SGD_RFAX_FECHRADI DESC, SGD_RFAX_FECH DESC
				";
				$rs = $db->conn->query($iSql);
				$usuaLogin = $rs->fields("USUA_LOGIN");
				$reservaFech = $rs->fields("SGD_RFAX_FECH");
				$radiFech = $rs->fields("SGD_RFAX_FECHRADI");
				$faxObserva = $rs->fields("SGD_RFAX_OBSERVA");
				$radiNumeRadi = $rs->fields("RADI_NUME_RADI");
				$radiPath = "../bodega/".substr($radiNumeRadi,0,4)."/".substr($radiNumeRadi,4,3)."/".$radiNumeRadi . ".tif";
				$hrefRadicado = "<a href='$radiPath' target=$radiNumeRadi>$radiNumeRadi</a>";
        $dsp_pages    = $dsp_line["5"];
        print "       <tr >\n";
        print "        <td $tClass>\n<span class=tpar>";
        print "$dsp_filename\n";
        print "        </span></td>\n";
        print "        <td $tClass>\n<span class=tpar>";
        print "<a target=image href='../bodega/faxtmp/$dsp_filename"."pdf'>Ver Pdf</a>/";
				if(file_exists("../bodega/faxtmp/$dsp_filename"."tif"))
		    {
					print "<a target=image href=../bodega/faxtmp/".$dsp_filename."tif>Ver tif</a>/";
				}
				else
				{
					print "/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/";
				}
				print "</td>\n";
        print "<td $tClass>\n<span class=tpar></span>$usuaLogin - $reservaFech</td>\n";
				print "<td $tClass>\n<span class=tpar></span>$hrefRadicado - $radiFech</td>\n";
				print "<td $tClass>\n<span class=tpar></span>$faxObserva</td>\n";
        print "</tr>\n";
        $no_queue++;
    }
}
		print("</tbody>");
		print("</table>");



	}
?>
