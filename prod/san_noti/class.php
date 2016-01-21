<?php 
class SANC_NOTI
{
   
   //var $cursor;
   var $row;
   var $radicado;
   function SANC_NOTI ($cursor)
   {
   }
	function mostrar_listado($val_modificar,$radicado,$cursor)
	{
	   
	   $isql = "select * from  $val_modificar  where radi_nume_radi = $radicado
	   
	   ";
	   $resultado = ora_parse($cursor,$isql) or die("<center><b>No se han encontrado registros con numero de radicado <font color=blue>$nurad</font> <br>  Revise el radicado escrito, solo pueden ser numeros de 14 digitos <br><p><hr><a href='edtradicado.php?fechaf=$fechaf&krd=$krd&drde=$drde'><font color=red>Intente de Nuevo</a><p><hr></font><p><p><p><p><p><p><p> Dato enviado por Oracle  <br><font color=blue>" .ora_error($cursor)." -- "); 
	   $resultado = ora_exec($cursor) or die("<center><b>No se han encontrado registros con numero de radicado <font color=blue>$nurad </font> <p><br>  Revise el radicado escrito, solo pueden ser numeros de 14 digitos <br><hr><a href='edtradicado.php?fechaf=$fechaf&krd=$krd&drde=$drde'><font color=red>Intente de Nuevo</a><p><hr></font><p><p><p><p><p><p><p> Dato enviado por Oracle<br><font color=blue> " .ora_error($cursor)." -- "); 
	   //ora_fetch_into($cursor,$this->row, ORA_FETCHINTO_NULLS|ORA_FETCHINTO_ASSOC);
	   ?>
	   <table border=1>
	   <?
	   while ($resultado=ora_fetch_into($cursor,$this->row, ORA_FETCHINTO_NULLS|ORA_FETCHINTO_ASSOC))
	   {
	     echo "<tr>
		 <td> " . $this->row["RADI_NUME_RADI"] ."</td>
         <td> " . $this->row["RADI_ASUN"] ."</td>		 
         <td> " . $this->row["RADI_USU_ANTE"] ."</td>		 
         <td> " . $this->row["RADI_NOMB"] ."</td>		 
         <td> " . $this->row["CARP_CODI"] ."</td>		 
		 </tr>";
	   }
	   ?>
	   </table>
	   <?
	}
	function mostrar_select($val_tabla,$val_select,$cursor,$campo_valor,$campo_descript,$camp_valor_selected=0)
	{
	   
	   $isql = "select $campo_valor,$campo_descript from  $val_tabla ";
	   $resultado = ora_parse($cursor,$isql) or die("<center><b>No se han encontrado registros con numero de radicado <font color=blue>$nurad</font> <br>  Revise el radicado escrito, solo pueden ser numeros de 14 digitos <br><p><hr><a href='edtradicado.php?fechaf=$fechaf&krd=$krd&drde=$drde'><font color=red>Intente de Nuevo</a><p><hr></font><p><p><p><p><p><p><p> Dato enviado por Oracle  <br><font color=blue>" .ora_error($cursor)." -- "); 
	   $resultado = ora_exec($cursor) or die("<center><b>No se han encontrado registros con numero de radicado <font color=blue>$nurad </font> <p><br>  Revise el radicado escrito, solo pueden ser numeros de 14 digitos <br><hr><a href='edtradicado.php?fechaf=$fechaf&krd=$krd&drde=$drde'><font color=red>Intente de Nuevo</a><p><hr></font><p><p><p><p><p><p><p> Dato enviado por Oracle<br><font color=blue> " .ora_error($cursor)." -- "); 
	   //ora_fetch_into($cursor,$this->row, ORA_FETCHINTO_NULLS|ORA_FETCHINTO_ASSOC);
	   ?>
	   <select name='<?=$val_tabla?>'>
	   <?
	   while (ora_fetch_into($cursor,$this->row, ORA_FETCHINTO_NULLS|ORA_FETCHINTO_ASSOC))
	   {
	     if($campo_val_selected==$this->row[$campo_valor]) $datoss = " Selected "; else  $datoss = " ";
		 echo "
		 <option value=".$this->row[$campo_valor] ."  '$datoss'>".$this->row[$campo_descript]."</option>";
	   }
	   ?>
	   </select>
	   <?
	}
	
}

?>
