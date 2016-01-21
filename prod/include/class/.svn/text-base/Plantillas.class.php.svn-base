<?php
class Plantilla
{

	var $error;
        var $db;
        var $arrayTpAyuda = array(1=>'Plantillas',2=>'Manuales',3=>'Instructivos');
	public function __construct($db) {
            $this->db= @$db;
        }

	function vistaDir($dir,$adm,$ruta_raiz="..")
	{
                if($adm)$colspan="colspan='2'";
		$dr=@opendir($dir);
		$tbl .="<table width='70%' align='center' cellpadding='0' cellspacing='5' class='borde_tab'>";
		if($adm)
		{
                    $tbl.="<tr bordercolor='#FFFFFF' >
                                <td align='center' class='titulos4' width='48%' colspan='2'><center>Administraci&oacute;n de archivos de ayuda</center></td>
                            </tr>
                            <tr bordercolor='#FFFFFF' >
                                 <td align='center' class='listado2' width='48%' >Archivo: <input name='filePlantilla' id='filePlantilla' size='30' class='tex_area' type='file'> </td>
                                 <td align='center'  class='listado2' width='48%' >Tipo:
                             ".$this->getComboTipoAyuda('tipoAyuda',"0:Selecciones")."
                            </tr>
                            <tr bordercolor='#FFFFFF' >
                                     <td align='center' class='listado2' colspan='2' width='48%' ><center><input type='submit'  id='fec' value='Agregar' class='botones' onclick='return agregar()'></center></td>
                            </tr>";
		}
                $tbl .="<tr bordercolor='#FFFFFF' >
                            <td align='center' class='titulos4' width='48%' colspan='2'><center>Listado de archivos</center></td>
			</tr>";
		if($dr)
		{
			// recorremos todos los elementos de la carpeta
			while (($carpetaTipoAyuda = readdir($dr)) !== false)
			{
				// comprobamos que sean archivos y no otras carpetas
				if(filetype($dir . $carpetaTipoAyuda)=="dir" && ($carpetaTipoAyuda!="." && $carpetaTipoAyuda!=".." && $carpetaTipoAyuda!=".svn"))
				{
                                    $drDe=@opendir($dir.$carpetaTipoAyuda);
                                    $i=0;
                                    $band=true;
                                    while (($archivo = readdir($drDe)) !== false)
                                    {
                                    	if($archivo!="." && $archivo!=".." && $archivo!=".svn")
                                    	{
                                    		if($band)
	                                    	 {
                                                    $tbl .="<tr bordercolor='#FFFFFF' >
                                                            <td  class='titulos2' bgcolor='#cccccc' $colspan>
                                                               <b>".strtoupper($carpetaTipoAyuda)."</b>
                                                            </td>";
                                                    $band=false;
	                                    	 }
                                                $tam  =round(filesize($dir.$carpetaTipoAyuda."/".$archivo)/1024,0);

                                                $tbl .="<tr bordercolor='#FFFFFF' >
                                                        <td  class='listado2'>
                                                                <a href='$ruta_raiz/seguridadImagen.php?fec=".base64_encode("Ayuda/$carpetaTipoAyuda/$archivo")."'>$archivo</a>
                                                        </td>";
                                                if($adm)
                                                {
                                                            $tbl.="<td  class='listado2'>
	                                                    <a href='javascript:borrar(\"".base64_encode("Ayuda/$carpetaTipoAyuda/$archivo")."\")'><center>Borrar</center></a>
	                                                    </td>";
	                                        }
	                                        $tbl.="</tr>";
                                    	}
                                    	$i++;
                                    }
                                    
				}
               
			}
			closedir($dr);
			$tbl.=	"</table>";
		}
		else return $dr;
		return $tbl;
	}
	
	function borraArchivo($rut)
	{
		try {
			include("../../config.php");
			$cmd = unlink("../../".$carpetaBodega.base64_decode($rut));
		}
		catch (Exception $e)
		{
			$this->error="Ocurri&oacute un error al borrar el archivo: ".$e->getMessage();
		}
		
	}
	
	function agregaArchivo($tipoAyuda)
	{
		try 
		{
			include_once "../../include/db/ConnectionHandler.php";
			include("../../config.php");
			include ("../../include/upload/upload_class.php");

			$db = new ConnectionHandler("../..");
			$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
			$sql="select * from anexos_tipo";
			$rs = $db->conn->Execute($sql);
			while(!$rs->EOF)
			{
				$ext[]= ".".$rs->fields["ANEX_TIPO_EXT"];
				$rs->moveNext();
			}
                        $my_upload = new file_upload();
                        $my_upload->language="es";
                        $my_upload->extensions=$ext;
                        //$my_upload->upload_dir = "../$carpetaBodega/tmp/"; // "files" is the folder for the uploaded files (you have to create this folder)
                        $my_upload->max_length_filename = 100; // change this value to fit your field length in your database (standard 100)
                        $newFile = trim(ucwords(strtolower($_FILES['filePlantilla']['name'])));
                        $uploadDir = "../../$carpetaBodega/Ayuda/".strtolower($this->arrayTpAyuda[$tipoAyuda])."/";
                        $my_upload->upload_dir = $uploadDir;
                        $my_upload->the_temp_file = $_FILES['filePlantilla']['tmp_name'];
                        $my_upload->the_file = $newFile;
                        $my_upload->http_error = $_FILES['filePlantilla']['error'];
                        $my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
                        if($i==0)
                        {
                                if ($my_upload->upload($newFile))
                                {
                                        // new name is an additional filename information, use this to rename the uploaded file
                                        $full_path = $my_upload->upload_dir.$my_upload->file_copy;
                                        $info = $my_upload->get_uploaded_file_info($full_path);
                                        // ... or do something like insert the filename to the database
                                }
                                else
                                {
                                                $this->error="<table width='31%' align='center' cellpadding='0' cellspacing='5' class='borde_tab'><tr><td class=titulosError>Ocurri&oacute un error al subir el archivo: <p>".$my_upload->show_error_string()."<br><blockquote>".nl2br($info)."</blockquote></td></tr></table>";
                                }
                        }
                        else
                        {
                                if(!is_dir($uploadDir))
                                {
                                        if(mkdir($uploadDir,0777,true))
                                        {
                                                copy($full_path,$uploadDir.$newFile);
                                        }
                                }else
                                {
                                        copy($full_path,$uploadDir.$newFile);
                                }
                        }
		}
		catch (Exception $e)
		{
			$this->error="Ocurri&oacute un error al subir el archivo: ".$e->getMessage();
		}
	}

        function getComboTipoAyuda($nombre='Slctp',$opcAdd=false,$opcDefault=false)
        {
            $opcArray = explode(':',$opcAdd);
            //die(count($opcArray));
            if ($opcAdd && (count($opcArray) <> 2)) return false;
            $tmp="<select name=$nombre id=$nombre class=select>";
            if ($opcAdd) $tmp .= "<option value='".$opcArray[0]."'>&lt;&lt;".$opcArray[1]."&gt;&gt;</option>";
            foreach ($this->arrayTpAyuda as $key => $valor)
            {
                $sel = ($opcDefault == $key) ? 'selected' : '';
                $tmp .= "<option value=$key $sel>$valor</option>";
            }
            $tmp .="</select>";
            return $tmp;
        }
}
?>
