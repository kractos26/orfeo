<?
$krdOld = $krd;
session_start();
if(!$krd) $krd=$krdOsld;
$ruta_raiz = "..";
if(!$_SESSION['dependencia'])	include "$ruta_raiz/rec_session.php";

$radicadosenvio= utf8_encode("Radicados Para Envío");
?>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
<table width="100%" border="0" cellspacing="5" cellpadding="0" class="borde_tab">
	<tr class='titulos2'>
			<td colspan="4">
					<img src='../imagenes/correo.gif'> Env&iacute;o de correspondencia &nbsp;
			</td>
	</tr>
	<tr align="center" class='listado2'>
			<td class='listado2' >
			<a href='../envios/cuerpoEnvioNormal.php?<?=$datos_enviar?>&estado_sal=3&estado_sal_max=3&krd=<?=$krd?>&nomcarpeta=<?=$radicadosenvio?>' class='vinculos'>Normal
			</a>
			</td>
			<td class='listado2' ><a href='../envios/cuerpoModifEnvio.php?<?=$datos_enviar?>&estado_sal=4&estado_sal_max=4&devolucion=3&krd=<?=$krd?>' class='vinculos'>Modificaci&oacute;n registro de env&iacute;o
			</a></td>
			<td class='listado2' ><a href='../radsalida/cuerpo_masiva.php?<?=$datos_enviar?>&krd=<?=$krd?>&estado_sal=3&estado_sal_max=3' class='vinculos'>Masiva
			</a></td>
			<td class='listado2'><b><a href='../radsalida/generar_envio.php?<?=$datos_enviar?>&krd=<?=$krd?>' class='vinculos'>Generaci&oacute;n de planillas
			y gu&iacute;as 
			</a></td>
	</tr>
</table>
<table><tr><td><p></p></td></tr></table>
<table width="100%" border="0" cellspacing="5" cellpadding="0" class="borde_tab">
  <tr class='titulos2'>
	 <td colspan="4">
        <img src='../imagenes/devoluciones.gif'> Devoluciones
	  </td>
      </tr>
</table>
<table width="100%" border="0" cellspacing="5" cellpadding="0" class="borde_tab">
	  <tr>
        <td class='listado2' height="25">
		  <a href='../devolucion/dev_corresp.php?<?=$datos_enviar?>&estado_sal=4&estado_sal_max=4&krd=<?=$krd?>' class='vinculos'>
		    Por exceder  tiempo de espera
          </a>
		</td>
        <td class='listado2' height="25">
		  <a href='../devolucion/cuerpoDevOtras.php?<?=$datos_enviar?>&estado_sal=4&estado_sal_max=4&devolucion=1&krd=<?=$krd?>' class='vinculos'>
		    Otras devoluciones
          </a>
		</td>
        <td class='listado2' height="25"><a href='../radsalida/dev_corresp2.php?<?=$datos_enviar?>&estado_sal=4&estado_sal_max=4'>
          </a>
		</td>
      </tr>
    </table>
	<p>
	<table width="100%" border="0" cellspacing="5" cellpadding="0" class="borde_tab">
  <tr class='titulos2'>
	 <td colspan="4">
        <img src='../iconos/anulacionRad.gif'> Anulaciones
	  </td>
      </tr>
	  <tr>
        <td class='listado2' height="25">
		  <a href='../anulacion/anularRadicados.php?<?=$datos_enviar?>&estado_sal=4&tpAnulacion=2&krd=<?=$krd?>' class="vinculos">
		    Anular radicados
          </a>
		</td>
    </table>
	<p>
		<table width="100%" border="0" cellspacing="5" cellpadding="0" class="borde_tab">
	  <tr class='titulos2'>
	  <td colspan="4">
        <img src='../imagenes/estadisticas_icono.gif'> Reportes </td>
      </tr>
	  <tr>
        <td class='listado2' height="25"><a href='../reportes/generar_estadisticas_envio.php?<?=$datos_enviar?>&estado_sal=4&estado_sal_max=4&krd=<?=$krd?>' class='vinculos'>
		  Env&iacute;o de correo
          </a>
		</td>
        <td class='listado2' height="25">
	<a href='../reportes/generar_estadisticas.php?<?=$datos_enviar?>&estado_sal=4&estado_sal_max=4&krd=<?=$krd?>' class='vinculos'>
		  Devoluciones
          </a></td>
		    <td class='listado2' height="25">
	       <a href='../anulacion/cuerpo_RepAnula.php?<?=$datos_enviar?>&estado_sal=4&tpAnulacion=2&krd=<?=$krd?>' class='vinculos'>
		  Anulaciones
          </a></td>
      </tr>
    </table>
