<?php
/*
 *
 * @ Multiple File upload script.
 *
 * @ Can do any number of file uploads
 * @ Just set the variables below and away you go
 *
 * @ Author: Kevin Waterson
 * @ Modified: Sebastian Ortiz V. 2012
 * @copywrite 2008 PHPRO.ORG
 *
 */

/*** an array to hold messages ***/
include_once "./cofigpqrs.php";

class Uploader {

	public $messages = array();
	public $FILES = array();
	public $subidos = array();
	public $sha1sums = array();
	public $sizes = array();
	public $nombreOrfeo = array();
	public $upload_dir= "../../poolsgc2013/tmp/";
	public $bodega_dir= "../../poolsgc2013/";
	public $listadoImprimible = "";
	public $tieneArchivos = false;

	public function Uploader($FilesList){
		$this->FILES = $FileList;
	}

	public function adjuntarYaSubidos(){
		foreach ($this->subidos as $archivosSubidos) {
			if(is_file($this->upload_dir.$archivosSubidos)){
			continue;
			}
			else{
			$error=1;
			}
		}
		if($error > 0 || sizeof($this->subidos) == 0){
			$this->tieneArchivos = false;
			return false;
		}else{
			$this->tieneArchivos = true;
			$this->listadoAdjuntosConHashesYaSubidos();
			return true;
		}
	}
	//Deprecated Ya no se usa por que se suben con FineUploader
	public function adjuntarArchivos(){
		$error = 0;
		error_reporting(E_ALL);
		/*** the upload directory ***/

		/*** the maximum filesize from php.ini ***/
		$ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
		$upload_max = $ini_max * 1024 * 1024;
		$max_file_size  = 5242880;
		/* Added to support a maximun upload size adding all individual file sizes */
		$uploaded_size = 0;
		/*** check if a file has been submitted ***/
		if(isset($this->FILES['userfile']['tmp_name']) && $this->FILES['userfile']['tmp_name'][0]=="")
		{
			return true;
		}
		if(isset($this->FILES['userfile']['tmp_name']))
		{
			/** loop through the array of files ***/
			for($i=0; $i < count($this->FILES['userfile']['tmp_name']);$i++)
			{
				// check if there is a file in the array
				if(!is_uploaded_file($this->FILES['userfile']['tmp_name'][$i]))
				{
					if(strlen($this->FILES['userfile']['tmp_name'][$i]) == 0){
						continue;
					}

					$this->messages[] = 'No se adjunto ningun archivo, o se alcanzo el tama&ntilde;o m&aacute;ximo.';
					$error += 1;
				}
				/*** check if the file is less then the max php.ini size ***/
				elseif($this->FILES['userfile']['size'][$i] + $uploaded_size > $upload_max)
				{
					$this->messages[] = "Los archivos superan el m&aacute;ximo permitido $upload_max php.ini limit (20M)";
					$error += 1;
				}
				// check the file is less than the maximum file size
				elseif($this->FILES['userfile']['size'][$i] > $max_file_size)
				{
					$this->messages[] = "El archivo supera el m&aacute;ximo permitido $max_file_size limit (5M)";
					$error += 1;
				}
				else
				{
					// Copiar los archivos a un directorio temporal mientras se obtiene un numero de radicado para asociarlos.
					if(@copy($this->FILES['userfile']['tmp_name'][$i],$this->upload_dir.'/'.basename($this->FILES['userfile']['tmp_name'][$i])))
					{
						/*** give praise and thanks to the php gods ***/
						$this->messages[] = $this->FILES['userfile']['name'][$i].' uploaded';
						$uploaded_size += $this->FILES['userfile']['size'][$i];
						$this->calcularSHA1SumAnexos(basename($this->FILES['userfile']['tmp_name'][$i]));
					}
					else
					{
						/*** an error message ***/
						$this->messages[] = 'Uploading '.$this->FILES['userfile']['name'][$i].' Failed';
						$error += 1;
					}
				}
			}
			if($error > 0){
				return false;
			}else{
				$this->tieneArchivos = true;
				$this->listadoAdjuntosConHashes();
				return true;
			}
		}
	}

	public function calcularSHA1SumAnexos($fileName){
		$this->sha1sums[] = sha1_file($this->upload_dir."/".$fileName);
		$this->sizes[] = intval(filesize($this->upload_dir."/".$fileName)/1024);
	}

	public function listadoAdjuntosConHashes(){
		if(!$this->tieneArchivos)
		{
			$this->listadoImprimible = "No se adjunta ningún archivo\n";
			return;
		}
		$this->listadoImprimible = "Se adjuntan los siguientes archivos:\n";
		for($i=0; $i < count($this->FILES['userfile']['name']);$i++)
		{
			if(strlen($this->FILES['userfile']['tmp_name'][$i]) == 0){
				continue;
			}
			$this->listadoImprimible .= ($i+1).". " . $this->FILES['userfile']['name'][$i] ." \tsha1sum: " . $this->sha1sums[$i]."\n";
		}

	}
	public function listadoAdjuntosConHashesYaSubidos(){
		if(isset($this->subidos) and sizeof($this->subidos)==0)
		{
			$this->listadoImprimible = "No se adjunta ningún archivo\n";
			return;
		}
		
		$this->listadoImprimible = "Se adjuntan los siguientes archivos:\n";
		
		for($i=0; $i < count($this->subidos);$i++)
		{
			if(strlen($this->subidos[$i]) == 0){
				continue;
			}
			$this->calcularSHA1SumAnexos($this->subidos[$i]);
			$this->listadoImprimible .= ($i+1).". " . $this->subidos[$i] ." \tsha1sum: " . $this->sha1sums[$i]."\n";
		}

	}
	public function moverArchivoCarpetaBodega($numrad){
            
		if(!$this->tieneArchivos)
		{
			return;
		}
		//Si todo fue bien entonces mover los archivos de la carpeta temporal a  bodega.
		for($i=0; $i < count($this->FILES['userfile']['name']);$i++)
		{
			if(strlen($this->FILES['userfile']['tmp_name'][$i]) == 0){
				continue;
			}
			$extension = end(explode('.',$this->FILES['userfile']['name'][$i]));
			//Bug fix si el archivo no tiene extensión.
			$extension = $extension?'.'.$extension:'';
			$this->nombreOrfeo[] = $numrad.'_'.substr('00000'. ($i+1) , -5).$extension;
			if(@rename($this->upload_dir.'/'.basename($this->FILES['userfile']['tmp_name'][$i]),$this->bodega_dir.'/'.$this->nombreOrfeo[$i])){
				echo "Archivo movido exitoso";
			}
			else {
				echo "Error moviendo a destino final";
			}
		}
	}
	public function moverArchivoCarpetaBodegaYaSubidos($numrad){
            
		if(!$this->tieneArchivos)
		{
			return;
		}
		//Si todo fue bien entonces mover los archivos de la carpeta temporal a  bodega.
		for($i=0; $i < count($this->subidos);$i++)
		{     
			if(strlen($this->subidos[$i]) == 0){
				continue;
			}
			$extension = end(explode('.',$this->subidos[$i]));
			//Bug fix si el archivo no tiene extensión.
			$extension = $extension?'.'.$extension:'';
			$this->nombreOrfeo[] = $numrad.'_'.substr('00000'. ($i+1) , -5).$extension;
                       
			if(rename($this->upload_dir.'/'.basename($this->subidos[$i]),$this->bodega_dir.'/'.$this->nombreOrfeo[$i])){
				//echo "Archivo movido exitoso";
			}
			else {
				//echo "Error moviendo a destino final";
			}
		}
	}
}
?>
