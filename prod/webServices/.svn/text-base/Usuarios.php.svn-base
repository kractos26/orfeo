<?php
	$ruta_raiz = "..";
	include_once("$ruta_raiz/include/db/ConnectionHandler.php");
	include_once("$ruta_raiz/include/tx/Radicacion.php");
	
	$db = new ConnectionHandler("$ruta_raiz");
	
	
	$depDestino 	= 905;		//dependencia destino a donde va dirigido
	$usuaDestino 	= 905001;	//Codigo del usuario que va el radicado
	$usuaCodi 	= 1;
	//$depDestino 	= 529;		//Dependencia destino a donde va dirigido
	//$usuaDestino 	= 1;		//usua_doc del usuario que va el radicado
	//$usuaCodi 	= 831;		//Codigo del usuario destino
	$tipoAnexo 	= 3;	
	
	$tipoRadicado 		= 2;
	$_SESSION['dependencia'] = $depDestino;
	$_SESSION['usua_doc'] 	= $usuaDestino;
	//$_SESSION['codusuario'] = 1;
	$_SESSION['codusuario'] = $usuaCodi;
	$_SESSION['nivelus'] 	= 5;
	/*
	$radicado->estaCodi = $estaCodi;
	$radicado->tipRad = $tipRad;
	$radicado->radiTipoDeri = $radiTipoDeri;
	$radicado->radiCuentai = $radiCuentai;*/
				/*		$eespCodi,
						$mrecCodi,
						$radiFechOfic,
						$radiNumeDeri,
						$tdidCodiRadi,
						$descAnex,
						$radiNumeHoja,
						$radiPais,
						$raAsun,
						$radiDepeRadi,
						$radiUsuaActu,
						$radiDepeActu,
						$carpCodi,
						$radiNumeRadi,
						$trteCodi,
						$radiNumeIden,
						$radiFechRadi,
						$sgd_apli_codi,
						$tdocCodi,
						$estaCodi,
						$radiPath,
						$dependencia,
						$usuaDoc,
						$usuaLogin,
						$usuaCodi,
						$codiNivel,
						$noDigitosRad*/
	$rad = new Radicacion($db);
	$rad->radiUsuaActu 	= $usuaDestino;
	$rad->radiDepeActu 	= $depDestino;
	// Creando el radicado
	$rad = new Radicacion($db);
	$rad->radiTipoDeri 	= 1 ;//$tpRadicado;
	$rad->radiCuentai	= "null";
	$rad->eespCodi 		= "null";	//$documento_us3;
	$rad->mrecCodi 		= 3;		// Codigo para ver por que medio llego a la super 3 es internet
//	$fecha_gen_doc_YMD 	= substr($fecha_gen_doc,6 ,4)."-".substr($fecha_gen_doc,3 ,2)."-".substr($fecha_gen_doc,0 ,2);
	$rad->radiFechOfic 	= date("d/m/Y");//$fecha_gen_doc_YMD;
	if(!$radicadopadre) 	$radicadopadre = null;
	$rad->radiNumeDeri 	= "null";	//trim($radicadopadre);
	$rad->radiPais 		= 170;		//$tmp_mun->get_pais_codi();
	$rad->descAnex 		= ""; //"Descripcion de Anexo";	//
	$rad->raAsun 		= "Pruebas a la SuperIntendencia"; // Asunto del radicado;
	$rad->radiDepeActu 	= $depDestino;	//$coddepe;
	$rad->radiDepeRadi 	= $depDestino;	//$coddepe;
	$rad->radiUsuaActu 	= $usuaCodi;	//$radi_usua_actu;
	$rad->trteCodi 		= 0;		//$tip_rem;
	$rad->tdocCodi 		= 0;		//$tdoc;	Suegerencia no tiene codigo Queja = 286 Reclamo = 399 
	$rad->tdidCodi 		= 0;		//$tip_doc;
	$rad->carpCodi 		= 0;		//$carp_codi;
	$rad->carPer 		= "null";	//$carp_per;
	$rad->trteCodi 		= 0;		//$tip_rem;
	$rad->ra_asun 		=  "radicado(a) via WEB";	
								// HLP Este si sirve? Para radicar se utiliza la variable $rad->raAsun )
	$rad->radiPath 		= 'null';			//
	$aplintegra 		= "0";				// Por defecto aplicaciones integradas Cero
	$rad->sgd_apli_codi 	= $aplintegra;
	$a = $rad->newRadicado(1,100);
	
		require_once($ruta_raiz . "/include/tx/Historico.php");
	
		$codTx 			= 2;
	$radicadosSel[0] = $noRad;
	$dependencia 	= $depDestino;
	$codusuario 	= $usuaCodi;
	$coddepe 	= $depDestino;
	$radi_usua_actu = $usuaCodi;
	$observacion 	= "Radicacion de QRS por WEB";
	$hist 		= new Historico($db);
	$hist->insertarHistorico($radicadosSel, 
					$dependencia,
					$codusuario,
					$coddepe,
					$radi_usua_actu,
					$observacion,
					$codTx);
		if(!empty($noRad) && $noRad !="-1"){
			$nurad = $noRad;
			$barnumber = $noRad;
			include_once($ruta_raiz . "/radicacion/grb_direcciones.php");
			include_once($ruta_raiz . "/include/barcode/index.php");
		}
	
	echo $a;
?>