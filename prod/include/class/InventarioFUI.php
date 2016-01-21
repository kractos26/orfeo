<?php
/** Formato Unico de Inventario.
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Grupo Iyunxi Ltda.
 *
 */
require("$ruta_raiz/fpdf/fpdf.php");
require('RecordSetToXml.class.php');
require("$ruta_raiz/radsalida/masiva/OpenDocText.class.php");

class InventarioFUI extends FPDF
{
    var $rs;
    var $widths;
    var $aligns;
    private $cnn;
    var $versionForm;
    var $tipo;
    var $tipoReporte;
    var $objODT;
    var $codigo;
    var $version;
    var $titulo;
    /**
     * Titulos de las columnas para el formato
     */
    var $headerTit;
    
    var $fase = array('AG'=>'Archivo Gestion','AC'=>'Archivo Central','AI'=>'Archivo Inactivo');
    var $uconservacion = array('CP'=>'Carpeta','EM'=>'Empaste','TM'=>'Tomo','OT'=>'Otro');

    function  __construct($db=null)
    {
        $this->cnn = $db;
        $this->objODT = new OpenDocText();
    }

    /**
     * Este metodo dibuja el formato unico de inventario
     *
     * @param RecordSet $recodSet 
     * @param array $titulos para 
     * @param array $widths
     */
    function creaFormato($recodSet,$titulos,$widths)
    {
    	
        parent::__construct('L','mm', 'legal');
        $this->getDatosParametros();
        $this->rs = $recodSet;
        $this->headerTit=$titulos;
        $this->widths=$widths;
        $this->SetFont('Arial','B',5);
        $this->SetMargins(20,10,2);
        //$this->SetRightMargin(0);
        $this->AddPage();
        $this->SetTitle("Formato único de Inventario");
        $this->SetAuthor("IYU");
        $this->SetCreator("Developed by Grupo Iyunxi Ltda.");
        $this->AliasNbPages();
        $this->cuerpo($recodSet);
        //$this->enlaceXML();
    }

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    /**
     * Encabezado del reporte.
     */
    function Header()
    {
        //Logo
        //$this->Image('logoCol.png',13,10,18);
        $this->Rect(20,10,60,18);
        $this->Image('../logoEntidad.gif',24,11,40);
        //Arial bold 15
        $this->SetFont('Arial','',12);
        $this->Cell(60);
        //TItulo
        $this->SetXY($this->GetX(),$this->GetY());
        $this->MultiCell(195,9,$this->titulo,1,'C');
	        
        $this->SetFont('Arial','',10);
        $this->SetXY($this->GetX()+255,$this->GetY()-18);
        $this->MultiCell(71,6,"".iconv($this->objODT->codificacion('Código:'),'ISO-8859-1','Código:')."".$this->codigo."\n".iconv($this->objODT->codificacion('Versión:'),'ISO-8859-1','Versión:') ."".$this->version."\n". iconv($this->objODT->codificacion('Pág.'),'ISO-8859-1','Pág.')."".$this->PageNo().'/{nb}',1);
        //$this->SetXY($this->GetX(),$this->GetY());
        $this->SetFont('Arial','',8);
        $this->Cell(36,5,iconv($this->objODT->codificacion('Disposición Final:'),'ISO-8859-1','Disposición Final:'),0,0,'L');
        $this->Cell(60,5,iconv($this->objODT->codificacion($this->tipoReporte),'ISO-8859-1',$this->tipoReporte),0,1,'L');
        $this->Cell(36,5,'Nombre Oficina Productora: ',0,0,'L');
        $this->Cell(60,5,$_SESSION['depe_nomb'],0,1,'L');
        //
        
	    $this->encabezado($this->headerTit);
    }

    /**
     * Pie de p�gina del reporte.
     */
    function Footer()
    {
        //Posicion: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',6);
        $this->Cell(70,3,'JEFE UNIDAD PRODUCTORA:_____________________________',0,0,'L');
        //$this->Cell(25,3,'',0,0,'L');
        $this->Cell(70,3,'FUNCIONARIO DE ARCHIVO:_____________________________',0,0,'L');
        //$this->Cell(25,3,'',0,0,'L');
        $this->Cell(70,3,'FECHA DE RECIBIDO:_____________________________',0,0,'L');
        //Numero de p?gina
        $this->Cell(10,10,iconv($this->objODT->codificacion('Pág.'),'ISO-8859-1','Pág.').$this->PageNo().'/{nb}',0,0,'C');
    }

    /**
     * Encabezado de la tabla del cuerpo del reporte.
     * @param array $data Los nombres de las columnas.
     */
    function encabezado($data)
    {
    	$this->SetFont('Arial','B',6.3);
    	$WIMP = $this->w - (2*$this->lMargin);
   		$n=0;
   		$y=5;
   		$band=true;
   		$iniY=$this->GetY();
   		$iniX=$this->GetX();
   		$this->SetFillColor(200,200,200);
   		foreach($data as $i=>$val)
   		{
   			$this->SetFont('Arial','B',6.3);
   			if(is_array($val))
   			{
   				foreach($val as $j => $val2)
   				{
   					$this->SetFont('Arial','B',5);
   					$band2=true;
   					if(is_array($val2))
	    			{
	    				foreach($val2 as $k => $val3)
	    				{
	    					if($band==true)
		    				{
		    					$this->MultiCell(($this->widths[$n]*$WIMP)/100,$y/3,$i,1,'C',true);
		    					$this->SetXY($this->GetX()+$acumX,$iniY+($y/3));
		    					$band=false;
		    				}
		    				if($band2==true)
		    				{
			    				$this->MultiCell((($this->widths[$n]*$WIMP)/100)/count($val2)/2,$y/3,$j,1,'C',true);
			    				$this->SetXY($this->GetX()+$acumX,$iniY+((2*($y))/3));
			    				$band2=false;
		    				}
		    				$this->MultiCell((($this->widths[$n]*$WIMP)/100)/count($val2)/2,$y/3,$val3,1,'C',true);
		    				$acumX=$acumX+(($this->widths[$n]*$WIMP)/100)/count($val2)/2;
		    				$this->SetXY($this->GetX()+$acumX,$iniY+((2*($y))/3));
	    				}
	    				$this->SetXY($this->GetX(),$iniY+($y/3));
	    			}
	    			else
	    			{
	    				if($band==true)
	    				{
	    					$this->MultiCell((($this->widths[$n]*$WIMP)/100),$y/2,$i,1,'C',true);
	    					$this->SetXY($this->GetX()+$acumX,$iniY+($y/2));
	    					$band=false;
	    				}
	    				$this->MultiCell((($this->widths[$n]*$WIMP)/100)/count($val),$y/2,$val2,1,'C',true);
	    				$acumX=$acumX+(($this->widths[$n]*$WIMP)/100)/count($val);
	    				$this->SetXY($this->GetX()+$acumX,$iniY+($y/2));
   					}
   				}
   				$this->SetXY($this->GetX(),$iniY);
   			}
   			else
   			{	
   				$this->MultiCell(($this->widths[$n]*$WIMP)/100,$y,$val,1,'C',true);
   				$acumX=$acumX+($this->widths[$n]*$WIMP)/100;
   				$this->SetXY($this->GetX()+$acumX,$iniY);
   			}
   			$n++;
   			$band=true;
   		}
   		$this->SetXY($iniX,$iniY+(2*$Y));
    }

    function cuerpo($rs)
    {
    	$this->Ln();
    	$this->Ln();
    	$WIMP = $this->w - (2*$this->lMargin);
    	$cont=1;
    	while (!$rs->EOF) 
    	{	
    		$j=1;
    		$conDiv=0;
    		$iniX=$this->GetX();
    		$iniY=$this->GetY();
    		$acum=($this->widths[0]*$WIMP)/100;
    		$this->MultiCell($acum,10,$cont,1,'C');
    		$div=count(next($this->headerTit));
    		$conDiv=count(current($this->headerTit));
    		$this->SetXY($iniX+$acum,$iniY);
    		foreach($rs->fields as $i=>$val)
	    	{	
	    		if($div>1 && $conDiv>0)
	    		{
	    			$div=count(current($this->headerTit));
	    			$conDiv--;
	    		}
	    		else
	    		{
	    			$div=count(next($this->headerTit));
    				$conDiv=$div-1;
    				$j++;
	    		}
	    		if($this->tipo=="ADMINISTRATIVO")$mas=15;
	    		else $mas=5;
	    		$porc=(($this->widths[$j]*$WIMP)/100/$div*0.68664034329)/1.8;
	    		if(strlen($val)>($this->widths[$j]*$WIMP)/100/$div)$val=substr($val,0,(($this->widths[$j]*$WIMP)/100/$div)+$porc+$mas);
	    		$this->Rect($iniX+$acum,$iniY,($this->widths[$j]*$WIMP)/100/$div,10);
	    		$this->MultiCell(($this->widths[$j]*$WIMP)/100/$div,5,iconv($this->objODT->codificacion($val),'ISO-8859-1',$val),0,'L');
	    		//$this->MultiCell(($this->widths[$j]*$WIMP)/100/$div,5,$val,1,'C');
	    		$acum=$acum+(($this->widths[$j]*$WIMP)/100/$div);
	    		$this->SetXY($iniX+$acum,$iniY);
	    	}
	    	//$this->Ln();
	    	$this->SetXY($iniX,$iniY+10);
	    	if(($cont%14)==0)
	    	{
	    		$this->AddPage();
	    		$this->Ln();
    			$this->Ln();
	    	}
	    	$rs->MoveNext();
	    	reset($this->headerTit);
	    	$cont++;
    	}
    }
    
    //Cargar los datos
    function LoadData($file)
    {
        //Leer las l?neas del fichero
        $lines=file($file);
        var_dump($lines);
        $data=array();
        foreach($lines as $line)
            $data[]=explode(';',chop($line));
        return $data;
    }

    function enlacePDF($i=0)
    {
    	include("../config.php");
        $band = true;
        $archivo = "/tmp/Fui".date('YmdHis')."$i.pdf";
        ($this->Output("../".$carpetaBodega.$archivo) == '') ? $band = "../seguridadImagen.php?fec=".base64_encode($archivo) : $band = false;
       return $band;
    }

    function enlaceXML($i=0)
    {
    	include("../config.php");
        $objRs2Xml = new RecodSetToXml($this->rs);
        $cadena = $objRs2Xml->creaXml();
        $archivo = "/tmp/Fui".date('YmdHis')."$i.xml";
        $gestor = file_put_contents("../".$carpetaBodega.$archivo, $cadena);
        if (!$gestor)
        {
             return $gestor;
        }
        return "../seguridadImagen.php?fec=".base64_encode($archivo);
    }

    /**
     * Retorna una cadena con un combo para las opciones de las fases de inventarios.
     * @param string $nombre. Nombre del objeto select a crear. Por defecto es SlcFases.
     * @param bool $opcAdd. (false - default) Si incluye nueva opci?n, enviar formato 'value:descripcion'.
     * @param string $opcDefault. Valor por defecto al crear el objeto select.
     * @return string Cadena con el select creado.
     */
    function getComboFase($nombre='SlcFases',$opcAdd=false,$opcDefault=false)
    {
        $opcArray = explode(':',$opcAdd);
        //die(count($opcArray));
        if ($opcAdd && (count($opcArray) <> 2)) return false;
        $tmp="<select name=$nombre id=$nombre class=select>";
        if ($opcAdd) $tmp .= "<option value='".$opcArray[0]."'>&lt;&lt;".$opcArray[1]."&gt;&gt;</option>";
        foreach ($this->fase as $key => $valor)
        {
            $sel = ($opcDefault == $key) ? 'selected' : '';
            $tmp .= "<option value=$key $sel>$valor</option>";
        }
        $tmp .="</select>";
        return $tmp;
    }

    /**
     * Retorna una cadena con un combo para las opciones de las fases de inventarios.
     * @param string $nombre. Nombre del objeto select a crear. Por defecto es SlcFases.
     * @param bool $opcTodos. (true - default) Incluye la opcion todos, (false) no la incluye.
     * @param string $opcDefault. Opci?n seleccionada por defecto al crear el objeto select.
     * @return string Cadena con el select creado.
     */
    function getComboUnidadConservacion($nombre='SlcUnCons',$opcTodos=true,$opcDefault=false)
    {
        $opcArray = explode(':',$opcTodos);
        //die(count($opcArray));
        if ($opcTodos && (count($opcArray) <> 2)) return false;
        $tmp="<select name=$nombre id=$nombre class=select>";
        if ($opcTodos) $tmp .= "<option value='".$opcArray[0]."'>".$opcArray[1]."</option>";
        foreach ($this->uconservacion as $key => $valor)
        {
            $sel = ($opcDefault == $key) ? 'selected' : '';
            $tmp .= "<option value=$key $sel>$valor</option>";
        }
        $tmp .="</select>";
        return $tmp;
    }

    function getDatosParametros()
    {
        $sql="select param_valor, param_nomb from sgd_parametro where param_nomb in ('REPORTE_TRANSFERENCIA_CODIGO','REPORTE_TRANSFERENCIA_VERSION','REPORTE_TRANSFERENCIA_TITULO')" ;
        $rs=$this->cnn->Execute($sql);
        if($rs and !$rs->EOF)
        {
            while(!$rs->EOF)
            {
                if($rs->fields['PARAM_NOMB']=='REPORTE_TRANSFERENCIA_CODIGO')$this->codigo=iconv($this->objODT->codificacion($rs->fields['PARAM_VALOR']),'ISO-8859-1',$rs->fields['PARAM_VALOR']);
                if($rs->fields['PARAM_NOMB']=='REPORTE_TRANSFERENCIA_VERSION')$this->version=iconv($this->objODT->codificacion($rs->fields['PARAM_VALOR']),'ISO-8859-1',$rs->fields['PARAM_VALOR']);
                if($rs->fields['PARAM_NOMB']=='REPORTE_TRANSFERENCIA_TITULO')$this->titulo=iconv($this->objODT->codificacion($rs->fields['PARAM_VALOR']),'ISO-8859-1',$rs->fields['PARAM_VALOR']);
                $rs->MoveNext();
            }
            if(mb_strlen($this->titulo,$this->objODT->codificacion($this->titulo))<80)$this->titulo.="\n ";
            else if (mb_strlen($this->titulo,$this->objODT->codificacion($this->titulo))>140)$this->titulo= mb_substr($this->titulo, 0,135);
            if (mb_strlen($this->codigo,$this->objODT->codificacion($this->codigo))>26)$this->codigo= mb_substr($this->codigo, 0,26);
            if (mb_strlen($this->version,$this->objODT->codificacion($this->version))>26)$this->version= mb_substr($this->version, 0,26);
        }
        else
        {
            $this->codigo='\n\n';
            $this->version='-';
            $this->titulo='-';
        }
    }
}
?>