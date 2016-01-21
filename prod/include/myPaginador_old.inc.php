<?php
$ruta_raiz=(isset($ruta_raiz))?((substr($ruta_raiz,-1)==".")?$ruta_raiz."/":$ruta_raiz):"../";
/**
 * paginador ispirado en la version de adodb,flexibilizando la forma de pintar la grilla
 * y la muestra de los titulos dependiendo de una funcion definida por el usuario, o en caso 
 * de no definir una funcion personalizada tomatra la idea de adodb  
 * flexibilizando la 
 */
require_once($ruta_raiz."include/db/ConnectionHandler.php");

class myPaginador{
	
	var $url;
	var $consulta;
	var $tamPagina=20;
	var $paginaActual;
	var $total;
	var $inicializado=false;
	var $imgOrdASC;
	var $imOrdDESC;
	var $ultimaPagina;
	var $totalPaginas;
	var $modoPintarCeldas=true; 
	var $variablesEstado;
	var $piePag=false;

	var $propiedadesTabla=array("width"=>"100%","border"=>"0","cellpadding"=>"0",
									"cellspacing"=>"5", "class"=>"borde_tab","align"=>"center");
	var $funcionPintaFilas;
	var $db; 	// ADODB connection object
	var  $rs;	// recordset generated
	
	var $showPageLinks=true; 

	// Localize text strings here
	var $first = '<code>|&lt;</code>';
	var $prev = '<code>&lt;&lt;</code>';
	var $next = '<code>>></code>';
	var $last = '<code>>|</code>';
	var $moreLinks = '...';
	var $startLinks = '...';
	var $htmlSpecialChars = true;
	var $page = 'Pagina';
	var $linkSelectedColor = 'green';
	var $cache = 0;  #secs to cache with CachePageExecute()
	var $id;
	var $toRefvar;
	var $linksPagina=10;
	var $toRefLinks;
	
	
	// variables Orfeo
	var $toRefLink;
	var $ordenPor;
	var $tipoOrden;
	var $rutaRaiz;

	
	
	 function myPaginador(&$db,$sql,$ordenadoPor,$tipodOrden="ASC",$tamPagina=20,$id="adodb",$showPageLinks = true){
		global $_GET,$_POST,$_SERVER;
		$this->db = $db;
		$this->url=(!empty($_GET))?$_SERVER['PHP_SELF']."?":$_SERVER['PHP_SELF'];
		$this->consulta = $sql;
		$this->id = $id;
		$this->db = $db;
		$this->tamPagina=(($tamPagina>=-1)&&(is_integer($tamPagina)))?$tamPagina:20;
		$this->rutaRaiz = $db->rutaRaiz;
		$this->showPageLinks = $showPageLinks;
		
		$total=$this->id."_total";
		$next_page = $id.'_next_page';
		$tipoOrden = $id."_tipo_orden";
		$ordenarPor =$id."_orden_por";
		
		$this->ordenarPor =$ordenadoPor==""?((isset($_POST[$ordenarPor]) && ($_POST[$ordenarPor])!="")?$_POST[$ordenarPor]:1):$ordenadoPor;
		$this->tipoOrden = $tipodOrden=="" || (isset($_POST[$tipoOrden]) && ($_POST[$tipoOrden])!="")?$_POST[$tipoOrden]:$tipodOrden;
		$this->total=isset($_SESSION[$total])?$_SESSION[$total]:(isset($_POST[$total]))?$_POST[$total]:false;
		$this->paginaActual=(isset($_POST[$next_page]))?$_POST[$next_page]:((isset($_GET[$next_page]))?$_GET[$next_page]:0);
		$this->inicializado=($this->total===false)?false:true;
		$this->variablesEstado=array($next_page,$total,$tipoOrden,$ordenarPor);
		$this->db->conn->SetFetchMode(0);
		$this->inicializar();
		$this->varGET();
	}
	 function calculaTotal() {
		if(!$this->inicializado){
			$consulta="SELECT COUNT (*) AS TOTAL FROM (".$this->consulta.")";
			// Modificado SGD 12-Septiembre-2007
			if( $this->db->driver == 'postgres')
			{
				$consulta .= " AS SUB";
			}
			$rs=&$this->db->conn->Execute($consulta);
			$this->total= $rs->fields['TOTAL'];
		}
		$this->totalPaginas=ceil($this->total/$this->tamPagina);
		$this->ultimaPagina=ceil($this->total/$this->tamPagina)-1;
	}
	
	function inicializar()
	{	if($this->ordenarPor)
		{	
			$ordenamineto=(strtoupper($this->tipoOrden)=="DESC")?" DESC ":" ASC ";
			
			//$this->consulta = strtoupper($this->consulta);
			$pos=0;
					
			$pos_select=strpos($this->consulta,"SELECT ",$pos);
			$pos = $pos_select;
					
			$posWHERE=strpos($this->consulta,"WHERE ",$pos);
			$pos = ($posWHERE==false) ? $pos : $posWHERE;
			
			$posGROUP=strrpos($this->consulta,"GROUP BY ",$pos);
			$pos = ($posGROUP==false) ? $pos : $posGROUP;
			
			$posHAVING=strrpos($this->consulta,"HAVING ",$pos);
			$pos = ($posHAVING==false) ? $pos : $posHAVING;
			 							
			$pos_order=strrpos($this->consulta,"ORDER BY ",$pos);
			$pos = ($pos_order==false) ? $pos : $pos_order;
			
			if($this->consulta[0]!="(" && $this->consulta[strlen($this->consulta)-1]==")")
			{
				$this->consulta.=" ORDER BY ".$this->ordenarPor." ".$ordenamineto;
			}
			elseif($pos===$pos_order)
			{
				$this->consulta=substr($this->consulta,0,$pos+9).$this->ordenarPor." ".$ordenamineto.",". substr($this->consulta,$pos+9);
			}
			else
			{
				$this->consulta=$this->consulta." ORDER BY ".$this->ordenarPor.$ordenamineto;
			}
		}	
	}
	
	function definirImagen()
	{
		$salida=(strtoupper($this->tipoOrden)=="ASC")?$this->imgOrdASC:$this->imOrdDESC;
		return $salida;
	}
	
	 function setImagenASC($pathASC){
		$this->imgOrdASC=$pathASC;
	}
	 function setImagenDESC($pathDESC){
		$this->imOrdDESC=$pathDESC;
	}
	 function setLinkSelectedColor($linkSelectedColor){
		$this->linkSelectedColor=$linkSelectedColor;
	}
     function getTotal(){ 
		return $this->total;
        }
     function getPaginaActual(){
		return $this->paginaActual;
        }
     function getId(){    
		return $this->id;
	}
	 function setpropiedadesTabla($propiedadesTabla){
		if($propiedadesTabla && is_array($propiedadesTabla))
		$this->propiedadesTabla=$propiedadesTabla;
	}
	 function setFuncionFilas($funcion){
		$this->funcionPintaFilas=$funcion;
	}
	 function modoPintado($pintarCelda){
		$this->modoPintarCeldas=$pintarCelda;
	}
	 function setToRefLinks($toRefLinks){
		$this->toRefLinks=$toRefLinks;
	}
	 function varPOST(){
		$salida="";
		foreach ($_POST as $clave=>$valor){
			if($this->variablesEstado!=null){
				if(!in_array($clave,$this->variablesEstado))
					$salida.=" \t\t\t<input type=\"hidden\" name=\"$clave\" value=\"$valor\" /> \n";
			}else{
				$salida.=" \t\t\t<input type=\"hidden\" name=\"$clave\" value=\"$valor\" /> \n";
			}
		}
		return $salida;
	}
	 function varGET(){
		foreach ($_GET as $clave=>$valor){
			if(!in_array($clave,$this->variablesEstado))
				$this->url.= "{$clave}=".urlencode($valor)."&";
		}	
	}
	 function setPie($pie){
		$this->piePag=$pie;
	 }
	//--------------------------
	// Display link to next page
	 function Render_Next ($anchor=true){
		$salida="";
		if ($anchor) {
		$salida.="<a href=\"#\" onclick=\"mandarFormaPaginador('{$this->id}formaPaginador','{$this->id}_next_page',".($this->paginaActual + 1).");\">{$this->next}</a> &nbsp;"; 
		} else {
			$salida="$this->next &nbsp; ";
		}
	 return $salida;
	}
	 function Render_Prev($anchor=true){
		$salida="";
		if ($anchor) {
		$salida= "<a href=\"#\" onclick=\"mandarFormaPaginador('{$this->id}formaPaginador','{$this->id}_next_page',".($this->paginaActual - 1).");\">{$this->prev}</a> &nbsp;"; 
		} else {
			$salida="$this->prev &nbsp; ";
		}
		return $salida;
	}
	 function Render_First($anchor=true){
  		if ($anchor) {
		$salida="<a href=\"#\" onclick=\"mandarFormaPaginador('{$this->id}formaPaginador','{$this->id}_next_page',0);\">{$this->first}</a> &nbsp;"; 
		} else {
			$salida="$this->first &nbsp; ";
		}
		return $salida;
	}
	 /**
	// Link to last page
	// 
	// for better performance with large recordsets, you can set
	// $this->db->conn->pageExecuteCountRows = false, which disables
	// last page counting.
	*/
	 function Render_Last($anchor=true){
		$saliada="";
	if (($this->totalPaginas > 1) && $anchor) {
		$salida="<a href=\"#\" onclick=\"mandarFormaPaginador('{$this->id}formaPaginador','{$this->id}_next_page',$this->ultimaPagina);\">{$this->last}</a> &nbsp; ";
		} else {
			$salida="$this->last &nbsp; ";
		}
		return $salida;
	}
	//---------------------------------------------------
	// original code by "Pablo Costa" <pablo@cbsp.com.br> 
	function Render_PageLinks(){
		
		$linksPagina = $this->linksPagina ? $this->linksPagina :10;
		$pages=ceil(($this->paginaActual/$this->linksPagina)+0.1);	
		$numbers = '';
					$end = $pages*$linksPagina;
					$start=$end-$linksPagina+1;
		if ($this->startLinks && $start > 1) {
			$pos = $start - 1;
			$numbers .= "<a href=\"#\" onclick=\"mandarFormaPaginador('{$this->id}formaPaginador','{$this->id}_next_page',{$pos});\">$this->startLinks</a>";
					} 
		
		for($i=$start; $i <= $end && $i< ($this->totalPaginas)+1; $i++) {
					if (($this->paginaActual) == ($i-1))
							$numbers .= "<font color=\"{$this->linkSelectedColor}\" size=2><b>{$i}</b></font>  ";
					else 
							$numbers .= "<a href=\"#\" onclick=\"mandarFormaPaginador('{$this->id}formaPaginador','{$this->id}_next_page',".($i-1).");\">{$i}</a> ";
			}
		if ($this->moreLinks && $end < $this->totalPaginas){
			$numbers .= "<a href=\"#\" onclick=\"mandarFormaPaginador('{$this->id}formaPaginador','{$this->id}_next_page',".($i-1).");\">{$this->moreLinks}</a>  ";
		}
			return $numbers . ' &nbsp; ';
	}
	// Link to previous page
	//-------------------------------------------------------
	// Navigation bar
	//
	// we use output buffering to keep the code easy to read.
	function RenderNav(){
		$s="";
		if ($this->paginaActual==0) {
			$s.=$this->Render_First(false);
			$s.=$this->Render_Prev(false);
		} else {
			$s.=$this->Render_First();
			$s.=$this->Render_Prev();
		}
		if ($this->showPageLinks){
            $s.=$this->Render_PageLinks();
        }
		if ($this->paginaActual==$this->ultimaPagina) {
			$s.=$this->Render_Next(false);
			$s.=$this->Render_Last(false);
		} else {
			$s.=$this->Render_Next();
			$s.=$this->Render_Last();
		}
		return $s;
	}
	//-------------------
	// This is the footer
	function RenderPageCount()
	{
		if($this->total > 0)
			if ($this->paginaActual > $this->ultimaPagina) $this->paginaActual = 0;
		$salida="<font size=1 class=\"tpar\"> items {$this->total}  pag ".($this->paginaActual+1)."/{$this->totalPaginas}</font>";
		return $salida;
	}
	
	
	//--------------------------------------------------------
	// Simply rendering of grid. You should override this for
	// better control over the format of the grid
	//
	// We use output buffering to keep code clean and readable.
	function generarPagina($columnasTitulo,$claseTitulo="titulos3",$noHayResultados='NO se Encontraron Resultados'){	
		$resultadosEncontrados=true;
		echo "<a name='anclaPaginador'></a> \n 
		<form action=\"{$this->url}\" method=\"POST\" name=\"{$this->id}formaPaginador\" id=\"{$this->id}formaPaginador\" >
		\n
		<table ";
		foreach ($this->propiedadesTabla as $clave=>$valor){
			echo" ".$clave."=\"".$valor."\" ";
		}
		echo " >";
		$claseTitulo=($claseTitulo)?"class=\"$claseTitulo\"":"";
		echo "\t \n <tr {$claseTitulo}> \n ";
		foreach($columnasTitulo as $clave=>$col){
			echo "\t  <th>  \n ";
			$posalm=strpos($col,"#");
			if(!$posalm){
				if(strlen($col) > 1)
					echo "\t".substr($col,1)." \n";
				else 
					echo "\t{$col} \n";
			}else{
				$ord=substr($col,0,$posalm);
				$imag=($this->ordenarPor==$ord)?"<img name=\"imagenOrden\" src=\"".$this->definirImagen()."\" />":"";
			echo "<a href=\"#\" onclick=\"cambiarOrden('{$this->id}formaPaginador','{$this->id}_orden_por','{$this->id}_tipo_orden','{$ord}');\" >".substr($col,$posalm+1)."</a>$imag  \n";
			}
			echo "</th> \n";
		}
		echo "\t </tr> \n";
		if($this->tamPagina==-1){
			$registroInicio=0;
			$resultado=&$this->db->conn->Execute($this->consulta);
		}else{
			$registroInicio=$this->tamPagina*$this->paginaActual;
			$resultado=&$this->db->conn->SelectLimit($this->consulta,$this->tamPagina,$registroInicio);
		}
		$i=$registroInicio;
		$numCols=count($columnasTitulo);
		//if($this->funcionPintaFilas!="")
		while(!$resultado->EOF){
			$i++;
			if($this->modoPintarCeldas){
				$claseTr=($i%2)==0?"class=\"listado2\"":"class=\"listado1\"";
				echo "\t <tr {$claseTr}> \n \t \t ";
				for($n=0; $n< $numCols;$n++){
					$celda=call_user_func($this->funcionPintaFilas,&$resultado->fields,$i,$n);
					if($celda!==false){
					echo "\t \t<td > $celda\t \t \n \t \t</td> \n";	
					}
				}
				echo " \t </tr> \n";
			}else{
				
				echo call_user_func($this->funcionPintaFilas,&$resultado->fields,$i);
			}
			$resultado->MoveNext();
		}
		if ($i===$registroInicio){
		echo "\t <tr> \n \t \t <td colspan=\"{$numCols}\" class=\"alarmas\"  align=\"center\"> \n \t \t {$noHayResultados} \n </td> \n \t </tr>	";
		}else {
			$this->calculaTotal();
			if($this->piePag)
			echo "\t <tr {$claseTitulo} > \n \t \t ".$this->piePag." \n \t \t</tr>";
		echo "\t <tr> \n \t \t <td colspan=\"{$numCols}\" align=\"center\"> \n \t \t".$this->RenderNav()."</td>
		 </tr>
		 \t<tr><td colspan=\"$numCols\" align=\"center\">\t \t ".$this->RenderPageCount()." \n </td> \n \t </tr>	";
		echo "</table> \n 
		<table>
		 <tr>
		 <td>
		  	<input type='hidden' name=\"{$this->id}_next_page\"   id=\"{$this->id}_next_page\"value=\"$this->paginaActual\" />
		  	<input type='hidden' name=\"{$this->id}_tipo_orden\"  id=\"{$this->id}_tipo_orden\" value=\"$this->tipoOrden\" />
		  	<input type='hidden' name=\"{$this->id}_orden_por\"   id=\"{$this->id}_orden_por\" value=\"$this->ordenarPor\" />
		  	<input type='hidden' name=\"{$this->id}_total\" value=\"$this->total\" />
		 	\n ".$this->VarPost()."
		  </td>
		 </tr>
		</table>
		</form> \n";
		}
		echo $this->piePaginador();
		return "";
	}
	function piePaginador(){
		$salida="<script language='javascript' type='text/javascript'>
				 function mandarFormaPaginador(formulario,pagEnvio,pagina){
		    		paginas=document.getElementById(pagEnvio);
					form=document.getElementById(formulario);
					paginas.value=pagina	
					form.submit();
				}
				function cambiarOrden(formulario,ordenPor,tipoOrden,columna){
					orden=document.getElementById(ordenPor);
					tipo=document.getElementById(tipoOrden);
					form=document.getElementById(formulario);
					if(orden.value==columna){
						tipo.value=(tipo.value.toUpperCase()==\"ASC\" || tipo.value==\"\")?\"DESC\":\"ASC\";
					}
					else{
					    tipo.value=\"ASC\";	
					    orden.value=columna;
					}
					
					form.submit();
				}	
				</script> \n";
		return $salida;
	} 
		
}

?>
