<?php
/**
 * Clase para manejar archivos OpenDocument Text (odt)
 *
 * @author  C'Mauricio Parra Romero
 *          cmauriciop@yahoo.com.mx
 * 			Modificaciones para Masiva -> Johnny Gonzalez
 *			Soporte ODT bajo Microsoft Windows -> Grupo Iyunxi Ltda.
 * @version v1.0 19/08/2005
 */

 class OpenDocText {
 /* Variables */
 	var $SO;
 	var $barra;
 	var $nombreOdt;		// Nombre Archivo + Extension
	var $nombreCompletoOdt;	// Path + Filename + Ext
	var $cacheDir;		// Directorio donde se va a descomprimir
	var $directorio;	// Ruta
	var $contenido;		// Contenido texto del archivo
	var $fp;		// Apuntador
	var $permiso;		// Permiso del archivo
	var $_debug = false;	// TRUE, FALSE
	var $workDir = '/home/orfeodev/jgonzal/public_html/br_3.6.0/bodega/tmp/workDir/';	// Directorio de trabajo para descomprimir el ODT ruta abs
	var $archivoSalida;	// Archivo de salida como se va enviar

	var $tempContent;   //contenido temporal para reemplazos
	var $bodyTagInit = '<office:body>'; 	//Etiqueta Inicial cuerpo del documento
	var $bodyTagEnd = '</office:body>';		//Etiqueta Final cuerpo del documento
	var $endDocTags = '</office:body></office:document-content>';	//Etiquetas de FinalizaciÃ³n de Documento ODT

 /* Variables privadas */
    var $_errorCode	= 0;
    var $_error		= '';
    var $_success	= '';
    var $cache		= false;// Variable para dejar el archivo en el directio
    var $stylesXml 	= 'content.xml';
    var $cabecerasXml 	= 'styles.xml';
    var $contenidoCabeceras;
    var $debug = false;

    /*Methodos publicos.*/
    /**
     * OpenDocText::OpenDocText()
     * Contructor de la clase
     * @return
     **/
    function OpenDocText()
    {
		$this->nombreCompletoOdt = '';
		if (strpos($_SERVER['SERVER_SOFTWARE'],'Win32'))
		{	$this->SO='W' ;
			$this->barra="\\\\";
		}
		else
		{	$this->SO='G';
			$this->barra='/';
	}	}

    /**
     * OpenDocText::cargarOdt()
     * Carga la informacion del archivo
     * @param $nombreArchivo Nombre del archivo completo con ruta
     * @param $cache Nombre del direcorio donde se va descomprimir el odt con ruta completa
     * @return
     **/
    function cargarOdt($nombreArchivo, $archivoSalida = null)
    {
    	$this->nombreCompletoOdt = str_replace("\\", "\\\\", realpath($nombreArchivo));
		//$this->archivoSalida = (isset($archivoSalida)) ? $archivoSalida . "_" . rand(0,255): 'archivoOdt' . rand();
		$nom = explode( ".", $archivoSalida );
		$this->archivoSalida = $nom[0];

		if (is_file($this->nombreCompletoOdt)) {
			$pathParts 	  	  = pathinfo($this->nombreCompletoOdt);
			$extension 	  	  = $pathParts["extension"];
			$this->directorio = $pathParts["dirname"];
			$this->nombreOdt  = $pathParts["basename"];
			$this->permiso    = fileperms($this->nombreCompletoOdt);
			$this->_success   = "Se cargo exitosamente la informacion de $this->nombreCompletoOdt.\n";
			( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Se cargo exitosamente la informacion de $this->nombreCompletoOdt. </td></tr></table>" ) : $error = '' ;
			echo $error;
			return true;
		} else {
			$this->_errorCode = 2;
			$this->_error 	  = "El $this->nombreCompleto no existe o no es un archivo.\n";
			$this->_debug();
			( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulosError>El $this->nombreCompletoOdt o no existe o no es un archivo.</td></tr></table>" ) : $error = '' ;
			echo $error;
			return false;
		}
    }

    /**
     * OpenDocText::setWorkDir()
     * Carga la informacion del contenido del archivo
     * @return
     **/
	function setWorkDir ($workDir) {
		$cambio = false;
		if (is_dir($workDir)) {
			$this->workDir = $workDir;
			$cambio = chdir($this->workDir);
			if ($cambio) {
					( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Realiz&oacute; el cambio al directorio  $this->workDir. </td></tr></table>" ) : $error = '' ;
			echo $error;
				$this->_success = "Realiz&oacute; el cambio al directorio $this->workDir.\n";
				$this->workDir = str_replace("\\", "\\\\", getcwd()) . $this->barra;
				$this->cacheDir = $this->workDir . 'cacheODT' .$this->barra;
			}else {
				( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulosError>NO Realiz&oacute; el cambio al directorio  $this->nombreCompletoOdt. </td></tr></table>" ) : $error = '' ;
			echo $error;
			}
			return true;
		}else {
			( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulosError>NO Existe; el directorio de trabajo temporal $this->workDir. </td></tr></table>" ) : $error = '' ;
			echo $error;
		return false;
		}

	}

    /**
     * OpenDocText::abrirOdt()
     * Carga la informacion del contenido del archivo
     * @return
     **/
	function setCacheDir ($path = null) {
		if (is_dir($path)) {
			$this->cacheDir = $path;
			return true;
		} else {
			return $this->cacheDir;
		}
	}

    /**
     * OpenDocText::abrirOdt()
     * Carga la informacion del contenido del archivo
     * @return
     **/
    function abrirOdt()
    {
		$nombreDir = array();
		$verificacion = '';
		$dirTmp = str_replace("\\", "\\\\", getcwd()) . $this->barra;
		$creoDir = false;
		$existeDir = false;
		if ($dirTmp == $this->workDir)
		{	
			$cmd_cp = "cp " . $this->nombreCompletoOdt . " " . $this->cacheDir;
			if(!is_dir($this->cacheDir)) mkdir($this->cacheDir,0777,true);
			switch ($this->SO)
			{	case 'W':
                {	
                	$cmd_cp = "cmd /C copy /Y " . $this->nombreCompletoOdt . " " . $this->cacheDir.str_replace('odt', 'zip', $this->nombreOdt);
					$WshShell = new COM('wscript.shell');
					$verificacion = $WshShell->Run($cmd_cp, 0, false);	
					$WshShell = null;
				}break;
				default:
				{
					$verificacion = shell_exec($cmd_cp);
				}break;
			}			
			if ($verificacion == '') 
			{	$nombreDir = explode('.',$this->nombreOdt);
				( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Copia el archivo : " .  $this->nombreCompletoOdt . " a " . $this->cacheDir ."</td></tr></table>" ) : $error = '' ;
				echo $error;
				$existeDir = is_dir($this->cacheDir . $nombreDir[0]);
				if (!$existeDir)
				{
					( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=info>No existe DIR: " . $this->cacheDir . $nombreDir[0]. " luego se crea</td></tr></table>" ) : $error = '' ;
					echo $error;

					$creoDir = mkdir($this->cacheDir . $nombreDir[0], 0777, true);
					if ($creoDir)
					{	( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Cre&oacute el directorio: " . $this->cacheDir . $nombreDir[0]. " todo ok</td></tr></table>" ) : $error = '' ;
						echo $error;
						$varTemp = "unzip -o " . $this->cacheDir . $this->nombreOdt ." -d " . $this->cacheDir . $nombreDir[0];
						switch ($this->SO)
						{	case 'W':
							{
								$varTemp = "cmd /C ".dirname(__FILE__). $this->barra ."unzip.exe -o " . $this->cacheDir . $nombreDir[0] . ".zip" ." -d " . $this->cacheDir . $nombreDir[0] . $this->barra;
								$WshShell = new COM("wscript.shell");
								$verificacion = $WshShell->Run($varTemp, 0, true);	
								$WshShell = null;
							}
							break;
							default:
							{
								$verificacion = shell_exec($varTemp);
							}break;
						}

						( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>$result: Descomprime : " . $varTemp ."</td></tr></table>" ) : $error = '' ;
						echo $error;
						
						$varTemp = "cp -Rf " . $this->cacheDir . $nombreDir[0] . " " . $this->workDir . $this->archivoSalida;
						switch ($this->SO)
						{	case 'W':
							{	
								$varTemp = "cmd /C xcopy " .$this->cacheDir.$nombreDir[0]." ".$this->workDir.$this->archivoSalida." /E /H /I";
								$WshShell = new COM("WScript.Shell");
								$verificacion = $WshShell->Run($varTemp, 0, true);	
								$WshShell = null;
							}
							break;
							default:
							{
								$verificacion = shell_exec($varTemp);
							}break;
						}
						
						( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Copia : " . $varTemp ."</td></tr></table>" ) : $error = '' ;
						echo $error;
					}
					else
					{
						( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulosError>No Cre&oacute; el directorio: " . $this->cacheDir . $nombreDir[0]. " Problemas</td></tr></table>" ) : $error = '' ;
						echo $error;

						$this->_errorCode = 10;
						$this->_error = "No ha sido posible crear el directorio" .	$this->cacheDir . $nombreDir[0] . ".\n" ;
						$this->_debug();
						return false;
				}	}
				else
				{
					chmod($this->cacheDir . $nombreDir[0], 0777);
				}
				//$varTemp = "cp -rf " . $this->cacheDir . $nombreDir[0] . " " . $this->workDir . $this->archivoSalida;
				$varTemp = "cp -Rf " . $this->cacheDir . $nombreDir[0] . " " . $this->workDir;
				switch ($this->SO)
				{	case 'W':
					{
						$varTemp = "cmd /C xcopy /E /Y /I " . $this->cacheDir.$nombreDir[0]. " " .$this->workDir.$this->archivoSalida;
						$WshShell = new COM("WScript.Shell");
						$verificacion = $WshShell->Run($varTemp, 0, true);
						$WshShell = null;
					}break;
					default:
					{
						$verificacion = shell_exec($varTemp);
					}break;
				}
				( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Copia Archivo salida: " . $varTemp. " </td></tr></table>" ) : $error = '' ;
				echo $error;
				return true;
			}
			else
			{
				return false;
		}	} 
		else
		{
			$this->_errorCode = 10;
			$this->_error = "No se encuentra en el directorio de trabajo $this->workDir.\n";
			$this->_debug();
			return false;
		}
    }

    /**
     * OpenDocText::cargarContenido()
     * Carga la informacion del archivo en un arreglo
     * @param $arreglo Arreglo donde se guardara el archivo
     * @return
     **/
    function cargarContenido(){
		$cambio = false;
		$esDir = false;
		$directorio = $this->workDir . $this->archivoSalida;
		$esDir = is_dir($directorio);
		( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=info>Directorio y archivo salida: $directorio </td></tr></table>" ) : $error = '' ;
		echo $error;
		if ($esDir){
			$varTmp = chmod($directorio,0777);
			$cambio = chdir($directorio);
            sleep(1);
			if ($cambio){
				//Cargo contenido del documento
				if(is_file($this->stylesXml)) {
					( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Conoce archivo contenido. </td></tr></table>" ) : $error = '' ;
					echo $error;
					$this->fp = fopen($this->stylesXml ,'r+');
					if ($this->fp) {
						$this->contenido = fread ($this->fp, filesize($this->stylesXml));
						$initIndex = strpos( $this->contenido, $this -> bodyTagInit );
						$endIndex =  strpos( $this->contenido, $this -> bodyTagEnd );
						$this -> tempContent = substr( $this->contenido, ($initIndex + strlen( $this -> bodyTagInit )) , $endIndex-$initIndex -  strlen( $this -> bodyTagEnd ) + 1);
						fclose( $this->fp ) ;
						$this -> contenido = str_replace($this -> endDocTags, "", $this->contenido);
						$contenido = substr($this->contenido, ($initIndex + strlen( $this -> bodyTagInit )) , strlen( $this -> contenido ));
				    	( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Contenido leido! $this->contenido </td></tr></table>" ) : $error = '' ;
						echo $error;

						$this -> contenido = str_replace($contenido, "", $this->contenido);
						//$this -> contenido = iconv("ISO-8859-1", "UTF-8", $this->contenido );
					} else {
						$this->_errorCode = 10;
						$this->_error = "No se pudo abrir el archivo $this->stylesXml.\n";
						$this->_debug();
						return false;
					}
				} else {
					$this->_errorCode = 4;
					$this->_error = "No existe el archivo $this->stylesXml.\n";
					$this->_debug();
					return false;
				}

				//Cargo contenido de las cabeceras
				if(is_file($this->cabecerasXml)) {
					$this->fp = fopen($this->cabecerasXml ,'r+');
					if ($this->fp) {
						$this->contenidoCabeceras = fread ($this->fp, filesize($this->cabecerasXml));
						fclose( $this->fp ) ;

					} else {
						$this->_errorCode = 10;
						$this->_error = "No se pudo abrir el archivo $this->cabecerasXml.\n";
						$this->_debug();
//						( $this->debug == true) ? ( $error = "<br><b>No existe el archivo de cabeceras.</b>";
						return false;
					}

					if ($this->contenido) {
						$this->_success = "Se cargo exitosamente el contenido de $this->cabecerasXml.\n";
						$this->_debug();
						return true;
					} else {
						$this->_errorCode = 4;
						$this->_error = "No se cargo el contenido de $this->cabecerasXml.\n";
						$this->_debug();
						return false;
					}
				} else {
					$this->_errorCode = 4;
					$this->_error = "No existe el archivo $this->cabecerasXml.\n";
					$this->_debug();
					return false;
				}
			} else {
				$this->_errorCode = 5;
				$this->_error = "No existe el directorio $this->archivoSalida.\n";
				$this->_debug();
				return false;
			}

		} else {
			$this->_errorCode = 5;
			$this->_error = "No existe el directorio $directorio.\n";
			$this->_debug();
			return false;
		}
    }

    /**
     * OpenDocText::setVariable()
     *
     * @return
     **/
    function setVariable($nombreVar = array(), $valorVar = array()){
		$arregloLon = count($nombreVar);
		$nVar = '';
		$vVar = '';
		$tempContent = $this->tempContent;
		$tempCab = $this->contenidoCabeceras;
		for($i = 0;$i < $arregloLon; $i++)
        {
            $nVar = ($nombreVar[$i] == null) ? '' : $nombreVar[$i];
			$vVar = ($valorVar[$i] == null) ? ''  : $this->xmlEntities(htmlentities($valorVar[$i],ENT_NOQUOTES,$this->codificacion($valorVar[$i])));
			$tempContent = str_replace(trim($nVar),trim($vVar),$tempContent);
			$tempCab = str_replace(trim($nVar),trim($vVar),$tempCab);
		}
		$this ->contenido = $this ->contenido . $tempContent;
		$this->contenidoCabeceras = $tempCab;
    }

    /**
     * Archivo::crear()
     *
     * @param $nombreCompleto
     * @return
     **/
    function crear($nombreCompleto) {
        if ($this->fp = fopen($nombreCompleto, 'w')) {
            $this->tamano = fwrite($this->fp,$this->contenido);
            fclose($this->fp);
            if (get_class($this) == 'ManejoArchivo') {
                $this->cargarInformacion($nombreCompleto);
            } else {
                ManejoArchivo::cargarInformacion($nombreCompleto);
            }
            $this->_success = "Se creo exitosamente $this->nombreCompleto.\n";


            $this->_debug();
            return TRUE;
        }
        else {
            $this->_errorCode = 13;
            $this->_error = "No se pudo crear $this->nombreCompleto.\n";
            $this->_debug();
            return FALSE;
        }
    }

    /**
     * OpenDocText::borrar()
     * Borra un archivo fisico
     * @return
     **/
    function borrar(){
    	switch ($this->SO)
		{	case 'W':
			{
				$nombreDir = explode('.',$this->nombreOdt);
				$cmd_del = "cmd /C del /Q " . $this->cacheDir . $nombreDir[0] . ".zip";
				$varTemp1 = str_replace("\\\\", "\\", $cmd_del) ;
				$cmd_del = "cmd /C rd /S /Q " . $this->cacheDir . $nombreDir[0];
				$varTemp2 = str_replace("\\\\", "\\", $cmd_del) ;
				$WshShell = new COM("WScript.Shell");
				$verificacion = $WshShell->Run($varTemp1, 0, true);
				$verificacion = $WshShell->Run($varTemp2, 0, true);
				$WshShell = null;
			}break;
			default:
			{
		   	 	exec( "rm -rf " . $this->cacheDir . "/*" );
    		 	exec( "rm -rf " . $this->workDir . "*.odt" );
			}
		}
        return TRUE;
    }
    
/**
 * 
 * Elimina una carpeta incluyendo TODO su contenido
 *
 * @param Char $folderPath
 * @return Boolean
 */
function RecursiveFolderDelete ( $folderPath )
{
    if ( is_dir ( $folderPath ) )
    {
        foreach ( scandir ( $folderPath )  as $value )
        {
            if ( $value != "." && $value != ".." )
            {
                $value = $folderPath . "/" . $value;

                if ( is_dir ( $value ) )
                {
                    RecursiveFolderDelete ( $value );
                }
                elseif ( is_file ( $value ) )
                {
                    @unlink ( $value );
                }
            }
        }

        return rmdir ( $folderPath );
    }
    else
    {
        return FALSE;
    }
}

    /**
     * OpenDocText::copiar()
     * Crea una copia del archivo
     * @param $nombreDestino nombre completo donde se
     * @return
     **/
    function copiar($nombreDestino, $remplazar = FALSE){
        if (file_exists($nombreDestino) && !($remplazar)) {
               $this->_errorCode = 7;
            $this->_error = "No se pudo copiar  el contenido de $this->nombreCompleto.\n"
                          . "El archivo  ya existe en el directorio";
            $this->_debug();
               return FALSE;
        } else {
            if (copy($this->nombreCompleto,$nombreDestino)){
                $this->_success = "Se copio exitosamente el contenido de  $this->nombreCompleto.\n";
                $this->_debug();
                return TRUE;
            }
             else {
                $this->_errorCode = 7;
                $this->_error = "No se pudo copiar  el contenido de $this->nombreCompleto.\n";
                $this->_debug();
                return FALSE;
            }
        }
    }

    /**
     * OpenDocText::salvarCambios()
     * Introduce la cadena modificada en el archivo styles.xml
     * @param string $contenido Contenido del archivo
     * @return
     **/
    function salvarCambios( $archivoTmp, $archivoFinal, $tipoUnitario )
	{
		$esArchivo = false;
		$esArchivo = is_file($this->stylesXml);
		
		$esArchivoStyles = false;
		$esArchivoStyles = is_file($this->cabecerasXml);
		
		$this->contenido = $this -> contenido . $this -> endDocTags;
		$error = '';
		
		if ($esArchivo)
		{
			( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Existe el archivo del contenido XML odt! $this->stylesXml </td></tr></table>" ) : $error = '' ;
			echo $error;
	        $this->fp = fopen($this->stylesXml,'w');

			if ($this->fp)
			{
	        	//Escribo contenido
				$tamano = fwrite($this->fp,$this->contenido);
	            if ($tamano)
	            {
       	        	( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>Se escribi&oacute; el contenido XML odt! $this->stylesXml </td></tr></table>" ) : $error = '' ;
					echo $error;

	                $this->_success = "Se escribio el contenido exitosamente en $this->stylesXml.\n";
	                $this->_debug();
	            }else
	            {
	             	( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulosError>NO SE PUDO escribi&oacute; el contenido XML odt! $this->stylesXml </td></tr></table>" ) : $error = '' ;
					echo $error;
	            }
	            fclose($this->fp);

	            $tamano = '';
	            if($esArchivoStyles)
	            {
	            	//Escribo cabeceras
		            if($tipoUnitario == '1')
		            {
		            	$filePointer = fopen( $this->cabecerasXml,'w' );
			            $tamano = fwrite( $filePointer, $this->contenidoCabeceras );

			            if ( $tamano )
			            {
       	       	        	( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>======Se escribi&oacute; el contenido de las cabeceras XML odt! $this->cabecerasXml</td></tr></table>" ) : $error = '' ;
							echo $error;

			                $this->_success = "Se escribio el contenido exitosamente en $this->cabecerasXml.\n";
			                $this->_debug();

			                fclose( $filePointer );

			            }else {
	             			( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulosError>NO SE PUDO escribir el contenido de las cabeceras XML odt! $this->cabecerasXml </td></tr></table>" ) : $error = '' ;
							echo $error;
			            }
					}
					( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=titulos2>Ya paso por verificacion unitario</td></tr></table>" ) : $error = '' ;
				} 

			    $nombreZip = explode(".",$this->archivoSalida);
			    $varTemp = "zip -r " . $this->workDir . $nombreZip[0] . ".odt *";
			    switch ($this->SO)
				{	case 'W':
					{	$varTemp = "cmd /C chdir /D ". $this->workDir.$nombreZip[0]." && ".dirname(__FILE__). $this->barra."zip.exe -rq " . $this->workDir . $nombreZip[0] . ".odt *";
						$WshShell = new COM("WScript.Shell");
						$verificacion = $WshShell->Run($varTemp, 0, true);
						$WshShell = null;
					}break;
					default:
					{
						$verificacion = shell_exec($varTemp);
					}break;
				}
			    switch ($this->SO)
				{	case 'W':
					{	$varTemp = "cmd /C chdir /D ". $this->workDir;
						$WshShell = new COM("WScript.Shell");
						$verificacion = $WshShell->Run($varTemp, 0, true);
						$ruta = $WshShell->Run("cmd /C chdir", 0, true);
						$WshShell = null;
					}break;
					default:
					{
						exec("cd " . $this->workDir );
						$ruta = shell_exec("pwd");
					}break;
				}
                if( $archivoTmp != null ){
	       	       	( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=titulos2> Viene temp</td></tr></table>" ) : $error = '' ;

					$vieneTemp = 1;
			    }else{
       	        	( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=titulos2> No viene temp sino definitivo</td></tr></table>" ) : $error = '' ;

					$vieneTemp = null;
			    }
				$intBodega = strpos($this->workDir, $this->barra."bodega"); //HLP OJO HLP
				if ( $intBodega === false )
				{
					$workDIR = str_replace($this->barra."tmp".$this->barra."workDir", "",$this->workDir);
					$archivoTmp = str_replace(".".$this->barra."bodega", "",$archivoTmp);
					$archivoFinal = str_replace(".".$this->barra."bodega", "",$archivoFinal);
				}else
				{
					$workDIR = str_replace($this->barra."tmp".$this->barra."workDir", "",$this->workDir);
					$archivoTmp = str_replace("bodega", "", $archivoTmp);
					$archivoFinal = str_replace("bodega", '',$archivoFinal); //HLP OJO HLP
				}

				if ($vieneTemp != null)
				{
					( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=info>Estamos en pruebas  </td></tr></table>" ) : $error = '' ;
					( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=info>Exec Copia: " . "cp " . $this->workDir . $nombreZip[0] . ".odt " .  $workDIR."/masiva/tmp_$nombreZip[0].odt   </td></tr></table>" ) : $error = '' ;
					$cmd_cp = "cp " . $this->workDir . $nombreZip[0] . ".odt " . $workDIR."/masiva/tmp_".$nombreZip[0]. ".odt ";
					switch ($this->SO)
					{	case 'W':
						{	$cmd_cp = "cmd /C copy /Y " . $this->workDir . $nombreZip[0] . ".odt " . $workDIR.$this->barra."masiva".$this->barra."tmp_".$nombreZip[0]. ".odt ";
							$WshShell = new COM("WScript.Shell");
							$verificacion = $WshShell->Run($cmd_cp, 0, true);
							$WshShell = null;
						}break;
						default:
						{
							$verificacion = shell_exec($cmd_cp);
						}break;
					}
					echo $error;
				}
				else
				{
		    		( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=info> Estamos en definitivo  </td></tr></table>" ) : $error = '' ;
		    		( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=info> WorkDir: " . $this->workDir . "  </td></tr></table>" ) : $error = '' ;
		    		( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=info> Archivo Final: " . $archivoFinal . "  </td></tr></table>" ) : $error = '' ;
			 		
					if ($tipoUnitario == '1')
					{	
						$cmd_cp = "cp " . $this->workDir.$nombreZip[0].".odt ".$workDIR . $archivoFinal ;
						switch ($this->SO)
						{	case 'W':
							{
								$cmd_cp = str_replace('/', $this->barra, $cmd_cp);
								$cmd_cp = str_replace('cp ', 'cmd /C move /Y ', $cmd_cp);
								$WshShell = new COM("WScript.Shell");
								$verificacion = $WshShell->Run($cmd_cp, 0, true);
								$WshShell = null;
							}break;
							default:
							{
								exec($cmd_cp);
							}break;
						}
					}else
					{	$cmd_cp = "cp " . $this->workDir . $nombreZip[0] . ".odt " . $workDIR .date('Y')."/".str_pad($_SESSION['dependencia'],3,"0", STR_PAD_LEFT)."/docs/".$nombreZip[0]. ".odt "   ;
						switch ($this->SO)
						{	case 'W':
							{	$cmd_cp = "cmd /C copy /Y " . $this->workDir . $nombreZip[0] . ".odt " . $workDIR .  str_replace("/", $this->barra , str_replace("//","", $archivoFinal));
								$WshShell = new COM("WScript.Shell");
								$verificacion = $WshShell->Run($cmd_cp, 0, true);
								$WshShell = null;
							}break;
							default:
							{
								exec($cmd_cp);
							}break;
						}
					} 
					( $this->debug == true) ? ( $error .= "<CENTER><table class=borde_tab><tr><td class=info>Exec Copia: " . $cmd_cp ." </td></tr></table>" ) : $error = '' ;
			    }

		    	if(chdir($this->workDir))
		    	{
		    		switch ($this->SO)
					{	case 'W':
						{
							$cmd_del = "cmd /C rd /S /Q ".$this->workDir . $this->archivoSalida;
							$WshShell = new COM("WScript.Shell");
							$verificacion = $WshShell->Run($cmd_del, 0, false);	
							$WshShell = null;
						}break;
						default:
						{
							exec("rm -rf ". $this->archivoSalida);
						}break;
					}
					if($archivoTmp)
	            	   return $archivoTmp;
					else if($archivoFinal)
			   			return $archivoFinal;
				}
				else
				{
					$this->_errorCode =  11;
					$this->_error = "No se pudo eliminar el directorio $this->archivoSalida.\n";
					$this->_debug();
					return false;
				}
				if($archivoTmp)
	            	return $archivoTmp;
				else if($archivoFinal)
			   		return $archivoFinal;
	        } else {
	            $this->_errorCode =  11;
	            $this->_error = "No se pudo abrir el archivo $this->stylesXml.\n";
	            $this->_debug();
	            return false;
	        }
        } else {
        	        	( $this->debug == true) ? ( $error = "<CENTER><table class=borde_tab><tr><td class=titulos2>NO Existe el archivo del contenido XML odt! $this->stylesXml No guarda nada.</td></tr></table>" ) : $error = '' ;
			echo $error;

//        	( $this->debug == true) ? ( $error = "<br><b>No archivo de Texto, no guarda nada! $this->stylesXml</b>";

            $this->_errorCode =  11;
            $this->_error = "No se pudo abrir el archivo o no se encuentra en directorio $this->stylesXml.\n";
            $this->_debug();
            return false;
        }
    }

    /**
     * OpenDocText::limpiarContenido()
     * Borra el contenido del archivo
     * @param string $contenido Contenido del archivo
     * @return
     **/
    function limpiarContenido(){
		$this->fp = fopen($this->nombreCompletoOdt,'w');
		if ($this->fp) {
		    $tamano = fwrite($this->fp,'');
		    fclose($this->fp);
		    $this->_success = "Se limpio el contenido exitosamente en $this->nombreCompleto.\n";
		    $this->_debug();
		    return TRUE;
		} else {
		    $this->_errorCode =  12;
		    $this->_error = "No se pudo abrir el archivo $this->nombreCompleto.\n";
		    $this->_debug();
		    return FALSE;
		}
    }

    function mover($nombreDestino, $remplazar = FALSE) {
        if (!($this->copiar($nombreDestino, $remplazar))) {
            return FALSE;
        } else {
            $this->borrar();
            $this->_success = "Se movio con exito $nombreDestino";
            $this->_debug();
            return TRUE;
        }
    }


	/**
	 * OpenDocText::descargar()
	 *
	 * @param $archivo
	 * @return
	 **/
	function descargar() {
		$nombreCompleto = '';
		$file			= array();
		$mimetype 		= 'application/vnd.oasis.opendocument.text';
		//$mimetype		= 'text/plan';
		//$mimetype		= '';
		$file = explode("_",$this->archivoSalida);


		$nombreCompleto = $this->workDir . $file[0] . ".odt";
		$partesNombre = pathinfo($nombreCompleto);


		header("Content-Length: " . filesize($nombreCompleto));
		header("Content-Type: $mimetype");


		if (is_file($nombreCompleto)) {
		    header("Content-Disposition: attachment; filename = " . basename($nombreCompleto));
		} else {
			header("Content-Disposition: attachment; filename=" . basename($nombreCompleto));
		}


		$leyo = readfile($nombreCompleto);
		if ($leyo) {
			exec("rm -rf " . $this->workDir . $this->archivoSalida);
			exec("rm -rf " . $nombreCompleto);
			return true;
		} else {
			return false;
		}
	}

 	/* Metodos Privados */
    function _debug() {
        if ($this->_debug){
            if ($this->_errorCode)  ("Error    :: $this->_error");
            else ( "Success  :: $this->_success");
        }
    }

   	/**
	 * OpenDocText::_OpenDocText()
	 * Destructor
	 * @param $tipoInfo
	 * @param $categoria
	 * @return
	 **/
    function _OpenDocText(){
        unset($this->contenido);
    }

    function agregarPagina($valorOriginal, $valorNuevo ){

			$this->contenido = str_replace($valorOriginal,$valorNuevo,$this->contenido);

    }

    function leeryReemplazarEtiquetaDEstilo(){

    	$cambio = false;
		$esDir = false;
		$directorio = $this->workDir . $this->archivoSalida;

		$esDir = is_dir($directorio);
		if ($esDir){
			$varTmp = chmod($directorio,0777);
			$cambio = chdir($directorio);

			$nVar = '<office:automatic-styles/>';
			$vVar = '<office:automatic-styles><style:style style:name="P1" style:family="paragraph" style:parent-style-name="Standard"><style:paragraph-properties fo:break-before="page"/></style:style></office:automatic-styles>';
			$this->fp = fopen($this->stylesXml ,'r+');
					if ($this->fp) {
						$this->contenido = fread ($this->fp, filesize($this->stylesXml));

						fclose($this->fp);

						$this->contenido = str_replace($nVar,$vVar,$this->contenido);

						$this->fp = fopen( $this->stylesXml ,'w');
						 if ($this->fp) {
				            $tamanoAP = fwrite($this->fp, $this->contenido);
					            if ($tamanoAP ){
					            }else {
					            	$this->_errorCode = 5;
									$this->_error = "No se pudo escribir en el archivo:  $this->stylesXml.\n";
									$this->_debug();
									return false;
					            }
					            fclose($this->fp);

					        } else {
					           $this->_errorCode = 5;
									$this->_error = "No se pudo abrir el archivo $this->fp.\n";
									$this->_debug();
									return false;
					        }

						//exit();
					} else {
						$this->_errorCode = 5;
									$this->_error = "No se pudo abrir el archivo $this->fp.\n";
									$this->_debug();
									return false;
					}
		}else {
				$this->_errorCode = 5;
				$this->_error = "No existe el directorio $this->archivoSalida.\n";
				$this->_debug();
				return false;
		}
    }

function unhtmlspecialchars( $string )
{
  $string = str_replace ( 'Ã¡', '&aacute;', $string );
  $string = str_replace ( 'Ã©', '&eacute;', $string );
  $string = str_replace ( 'Ã­', '&iacute;', $string );
  $string = str_replace ( 'Ã³', '&oacute;', $string );
  $string = str_replace ( 'Ãº', '&uacute;', $string );
  $string = str_replace ( 'Ã�', '&Aacute;', $string );
  $string = str_replace ( 'Ã‰', '&Eacute;', $string );
  $string = str_replace ( 'Ã�', '&Iacute;', $string );
  $string = str_replace ( 'Ã“', '&Oacute;', $string );
  $string = str_replace ( 'Ãš', '&Uacute;', $string );
  $string = str_replace ( 'Ã±', '&ntilde;', $string );
  $string = str_replace ( 'Ã‘', '&Ntilde;', $string );

  return $string;
}

//funcion que convierte entidades html a entidades xml
function xmlEntities($str)
{
    $xml  = array(	'&#208;','&#240;','&#222;','&#254;','&#198;','&#230;','&#223;','&#338;','&#339;','&#180;',
					'&#732;','&#710;','&#168;','&#184;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;',
					'&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#209;',
					'&#210;','&#211;','&#212;','&#213;','&#214;','&#216;','&#352;','&#217;','&#218;','&#219;',
					'&#220;','&#221;','&#376;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#231;',
					'&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#241;','&#242;',
					'&#243;','&#244;','&#245;','&#246;','&#248;','&#353;','&#249;','&#250;','&#251;','&#252;',
					'&#253;','&#255;','&#8201;','&#160;','&#8194;','&#8195;','&#8204;','&#8205;','&#8206;','&#8207;',
					'&#161;','&#191;','&#183;','&#8216;','&#8217;','&#8218;','&#34;','&#8220;','&#8221;','&#8222;',
					'&#8249;','&#8250;','&#171;','&#187;','&#9001;','&#9002;','&#38;','&#173;','&#8211;','&#8212;',
					'&#175;','&#8254;','&#166;','&#167;','&#182;','&#8226;','&#8230;','&#169;','&#174;','&#8482;',
					'&#9674;','&#8224;','&#8225;','&#8968;','&#8969;','&#8970;','&#8971;','&#185;','&#178;','&#179;',
					'&#188;','&#189;','&#190;','&#170;','&#186;','&#176;','&#8242;','&#8243;','&#215;','&#247;',
					'&#8240;','&#60;','&#62;','&#172;','&#177;','&#8260;','&#8704;','&#8706;','&#8707;','&#8709;',
					'&#8711;','&#8712;','&#8713;','&#8715;','&#8719;','&#8721;','&#8722;','&#8727;','&#8730;','&#8733;',
					'&#8734;','&#8736;','&#8743;','&#8744;','&#8745;','&#8746;','&#8747;','&#8756;','&#8764;','&#8773;',
					'&#8776;','&#8800;','&#8801;','&#8804;','&#8805;','&#8834;','&#8835;','&#8836;','&#8838;','&#8839;',
					'&#8853;','&#8855;','&#8869;','&#8901;','&#162;','&#163;','&#165;','&#402;','&#8364;','&#164;',
					'&#913;','&#914;','&#915;','&#916;','&#917;','&#918;','&#919;','&#920;','&#921;','&#922;',
					'&#923;','&#924;','&#925;','&#926;','&#927;','&#928;','&#929;','&#931;','&#932;','&#933;',
					'&#934;','&#935;','&#936;','&#937;','&#945;','&#946;','&#947;','&#948;','&#949;','&#950;',
					'&#951;','&#952;','&#953;','&#954;','&#955;','&#956;','&#957;','&#958;','&#959;','&#960;',
					'&#961;','&#962;','&#963;','&#964;','&#965;','&#966;','&#967;','&#968;','&#969;','&#181;',
					'&#977;','&#978;','&#982;','&#8501;','&#8472;','&#8465;','&#8476;','&#8592;','&#8593;','&#8594;',
					'&#8595;','&#8596;','&#8629;','&#8656;','&#8657;','&#8658;','&#8659;','&#8660;','&#9824;','&#9827;',
					'&#9829;','&#9830;');
    
    $html = array(	'&ETH;','&eth;','&THORN;','&thorn;','&AElig;','&aelig;','&szlig;','&OElig;','&oelig;','&acute;',
					'&tilde;','&circ;','&uml;','&cedil;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;',
					'&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&Ntilde;',
					'&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&Oslash;','&Scaron;','&Ugrave;','&Uacute;','&Ucirc;',
					'&Uuml;','&Yacute;','&Yuml;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&ccedil;',
					'&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&ntilde;','&ograve;',
					'&oacute;','&ocirc;','&otilde;','&ouml;','&oslash;','&scaron;','&ugrave;','&uacute;','&ucirc;','&uuml;',
					'&yacute;','&yuml;','&thinsp;','&nbsp;','&ensp;','&emsp;','&zwnj;','&zwj;','&lrm;','&rlm;',
					'&iexcl;','&iquest;','&middot;','&lsquo;','&rsquo;','&sbquo;','&quot;','&ldquo;','&rdquo;','&bdquo;',
					'&lsaquo;','&rsaquo;','&laquo;','&raquo;','&lang;','&rang;','&amp;','&shy;','&ndash;','&mdash;',
					'&macr;','&oline;','&brvbar;','&sect;','&para;','&bull;','&hellip;','&copy;','&reg;','&trade;',
					'&loz;','&dagger;','&Dagger;','&lceil;','&rceil;','&lfloor;','&rfloor;','&sup1;','&sup2;','&sup3;',
					'&frac14;','&frac12;','&frac34;','&ordf;','&ordm;','&deg;','&prime;','&Prime;','&times;','&divide;',
					'&permil;','&lt;','&gt;','&not;','&plusmn;','&frasl;','&forall;','&part;','&exist;','&empty;',
					'&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;',
					'&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;',
					'&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;',
					'&oplus;','&otimes;','&perp;','&sdot;','&cent;','&pound;','&yen;','&fnof;','&euro;','&curren;',
					'&Alpha;','&Beta;','&Gamma;','&Delta;','&Epsilon;','&Zeta;','&Eta;','&Theta;','&Iota;','&Kappa;',
					'&Lambda;','&Mu;','&Nu;','&Xi;','&Omicron;','&Pi;','&Rho;','&Sigma;','&Tau;','&Upsilon;',
					'&Phi;','&Chi;','&Psi;','&Omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;',
					'&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;',
					'&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&micro;',
					'&thetasym;','&upsih;','&piv;','&alefsym;','&weierp;','&image;','&real;','&larr;','&uarr;','&rarr;',
					'&darr;','&harr;','&crarr;','&lArr;','&uArr;','&rArr;','&dArr;','&hArr;','&spades;','&clubs;',
					'&hearts;','&diams;');
    
    $str  = str_replace($html,$xml,$str);
    $str  = str_ireplace($html,$xml,$str);
    return $str;
}

  
function codificacion($texto)
{ 
     $c = 0;
     $ascii = true;
     for ($i = 0;$i<strlen($texto);$i++) 
     {
         $byte = ord($texto[$i]);
         if ($c>0) 
         {
             if (($byte>>6) != 0x2)
             {
                 return 'ISO-8859-1';
             }
             else
             {
                 $c--;
             }
         } 
         elseif ($byte&0x80) 
         {
             $ascii = false;
             if (($byte>>5) == 0x6)
             {
                  $c = 1;
             }
             elseif (($byte>>4) == 0xE)
             {
                 $c = 2;
             }
             elseif (($byte>>3) == 0x1E)
             {
                 $c = 3;
             }
             else 
             {
                 return 'ISO-8859-1';
             }
         }
     }
     return ($ascii) ? 'ISO-8859-1' : 'UTF-8';
}
function setDebugMode( $debugMode ){
	$this->debug = $debugMode;
}
}
?>
