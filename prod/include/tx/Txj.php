<?

include_once($ruta_raiz . "/include/tx/Historico.php");

class Tx extends Historico {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * Clase que maneja los Historicos de los documentos
     *
     * @param int     Dependencia Dependencia de Territorial que Anula
     * @param number  usuaDocB    Documento de Usuario
     * @param number  depeCodiB   Dependencia de Usuario Buscado
     * @param varchar usuaNombB   Nombre de Usuario Buscado
     * @param varcahr usuaLogin   Login de Usuario Buscado
     * @param number	usNivelB	Nivel de un Ususairo Buscado..
     * @db 	Objeto  conexion
     * @access public
     */
    var $db;

    function Tx($db) {
        /**
         * Constructor de la clase Historico
         * @db variable en la cual se recibe el cursor sobre el cual se esta trabajando.
         *
         */
        $this->db = $db;
        //$this->db->conn->debug=true;
    }

    /**
     * Metodo que trae los datos principales de un usuario a partir del codigo y la dependencia
     *
     * @param number $codUsuario
     * @param number $depeCodi
     *
     */
    function datosUs($codUsuario, $depeCodi) {
        $sql = "SELECT
				USUA_DOC
				,USUA_LOGIN
				,CODI_NIVEL
				,USUA_NOMB
			FROM
				USUARIO
			WHERE
				DEPE_CODI=$depeCodi
				AND USUA_CODI=$codUsuario";
        # Busca el usuairo Origen para luego traer sus datos.
        //$this->db->conn->debug=true;

        $rs = $this->db->query($sql);
        //$usNivel = $rs->fields["CODI_NIVEL"];
        //$nombreUsuario = $rs->fields["USUA_NOMB"];
        $this->usNivelB = $rs->fields['CODI_NIVEL'];
        $this->usuaNombB = $rs->fields['USUA_NOMB'];
        $this->usuaDocB = $rs->fields['USUA_DOC'];
    }

    function informar($radicados, $loginOrigen, $depDestino, $depOrigen, $codUsDestino, $codUsOrigen, $observa, $idenviador = null, $mailObj = null) {
        $whereNivel = "";
        //$this->db->conn->debug=true;
        $this->db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
        $sql = "SELECT
				USUA_DOC
				,USUA_LOGIN
				,CODI_NIVEL
				,USUA_NOMB
                                ,USUA_EMAIL
                                ,EMAIL_NOTIF
			FROM
				USUARIO
			WHERE
				DEPE_CODI=$depDestino
				AND USUA_CODI=$codUsDestino";
        # Busca el usuairo Origen para luego traer sus datos.
        $rs = $this->db->query($sql); # Ejecuta la busqueda
        $usNivel = $rs->fields["CODI_NIVEL"];
        $usLoginDestino = $rs->fields["USUA_LOGIN"];
        $nombreUsuario = $rs->fields["USUA_NOMB"];
        $docUsuarioDest = $rs->fields["USUA_DOC"];
        $usuaEmail = $rs->fields["USUA_EMAIL"];
        $emailNotif = $rs->fields["EMAIL_NOTIF"];
        $codTx = 8;
        if ($tomarNivel == "si") {
            $whereNivel = ",CODI_NIVEL=$usNivel";
        }
        $codTx = 8;
        $observa = "A: $usLoginDestino - $observa";
        if (!$observacion)
            $observacion = $observa;

        $tmp_rad = array();
        $informaSql = true;
        //$this->db->conn->debug=true;
        while ((list(, $noRadicado) = each($radicados)) and $informaSql) {
            if (strstr($noRadicado, '-'))
                $tmp = explode('-', $noRadicado);
            else
                $tmp = $noRadicado;
            if (is_array($tmp)) {
                $record["RADI_NUME_RADI"] = $tmp[1];
            } else {
                $record["RADI_NUME_RADI"] = $noRadicado;
            }
            # Asignar el valor de los campos en el registro
            # Observa que el nombre de los campos pueden ser mayusculas o minusculas
            //insert into INFORMADOS(DEPE_CODI,INFO_FECH,USUA_CODI,RADI_NUME_RADI,INFO_DESC) values ($depsel, to_date ($formatfecha) ,$codus,$chk3,'$observa')
            //$record["RADI_NUME_RADI"] = $noRadicado;
            $record["DEPE_CODI"] = $depDestino;
            $record["USUA_CODI"] = $codUsDestino;
            $record["INFO_CODI"] = "'$idenviador'";
            $record["INFO_DESC"] = "'$observacion '";
            $record["USUA_DOC"] = "'$docUsuarioDest'";
            $record["INFO_FECH"] = $this->db->conn->OffsetDate(0, $this->db->conn->sysTimeStamp);
            /*
             * Notificacion por correo si la persona la habilita desde el m�dulo de administracion
             */
            if ($codUsDestino == $codUsOrigen && $depDestino == $depOrigen) {
                $siMismo = true;
            } else {
                $siMismo = false;
            }
            if (((int) $emailNotif === 1))
            {
            	if ( (!$siMismo)  && $mailObj && $this->comprobar_email($usuaEmail)) {
	                $sqlRadData = "select rad.radi_nume_radi num, 
	                                    rad.ra_asun asunto, 
	                                    tp.sgd_tpr_descrip tipo 
	                             from radicado rad 
	                             inner join sgd_tpr_tpdcumento tp on tp.sgd_tpr_codigo=rad.tdoc_codi 
	                             where rad.radi_nume_radi=" . $record["RADI_NUME_RADI"] . " ";
	                $rsRadData = $this->db->query($sqlRadData);
	                $mailContent['transUpper'] = 'INFORMADO';
	                $mailContent['to'] = $nombreUsuario;
	                $mailContent['transLower'] = 'Informado';
	                $mailContent['tpDoc'] = $rsRadData->fields['TIPO'];
	                $mailContent['radiNum'] = $record["RADI_NUME_RADI"];
	                $mailContent['asunto'] = $rsRadData->fields['ASUNTO'];
	                $mailContent['comment'] = $observa;
	                $Subject = "Informado de radicado " . $record["RADI_NUME_RADI"];
	                $this->CreateAndSend($mailObj, $usuaEmail, $nombreUsuario, $Subject, $mailContent);
            	}
            }

            # Mandar como parametro el recordset vacio y el arreglo conteniendo los datos a insertar
            # a la funcion GetInsertSQL. Esta procesara los datos y regresara un enunciado SQL
            # para procesar el INSERT.
            $informaSql = $this->db->conn->Replace("INFORMADOS", $record, array('RADI_NUME_RADI', 'INFO_CODI', 'USUA_DOC'), false);

            //Modificado idrd 
            if ($informaSql)
                $tmp_rad[] = $record["RADI_NUME_RADI"];
        }
        $this->insertarHistorico($tmp_rad, $depOrigen, $codUsOrigen, $depDestino, $codUsDestino, $observa, $codTx);
        return $nombreUsuario;
    }

    function borrarInformado($radicados, $loginOrigen, $depDestino, $depOrigen, $codUsDestino, $codUsOrigen, $observa) {
        $tmp_rad = array();
        $deleteSQL = true;
        //$this->db->conn->debug=true;
        while ((list(, $noRadicado) = each($radicados)) and $deleteSQL) { //foreach($radicados as $noRadicado)
            # Borrar el informado seleccionado
            $tmp = explode('-', $noRadicado);
            ($tmp[0]) ? $wtmp = ' and INFO_CODI = \'' . $tmp[0] . "'" : $wtmp = ' and INFO_CODI IS NULL ';
            $record["RADI_NUME_RADI"] = $tmp[1];
            $record["USUA_CODI"] = $codUsOrigen;
            $record["DEPE_CODI"] = $depOrigen;
            $deleteSQL = $this->db->conn->Execute("DELETE FROM INFORMADOS WHERE RADI_NUME_RADI=" . $tmp[1] . " and USUA_CODI='" . $codUsOrigen . "' and DEPE_CODI=" . $depOrigen . $wtmp);
            if ($deleteSQL)
                $tmp_rad[] = $record["RADI_NUME_RADI"];
        }
        $codTx = 7;
        if ($deleteSQL) {
            $this->insertarHistorico($tmp_rad, $depOrigen, $codUsOrigen, $depOrigen, $codUsOrigen, $observa, $codTx, $observa);
            return $tmp_rad;
        }
        else
            return $deleteSQL;
    }

    function cambioCarpeta($radicados, $usuaLogin, $carpetaDestino, $carpetaTipo, $tomarNivel, $observa) {
        $whereNivel = "";
        $sql = "SELECT
					b.USUA_DOC
					,b.USUA_LOGIN
					,b.CODI_NIVEL
					,b.DEPE_CODI
					,b.USUA_CODI
					,b.USUA_NOMB
				FROM
					 USUARIO b
				WHERE
					b.USUA_LOGIN = '$usuaLogin'";
        # Busca el usuairo Origen para luego traer sus datos.
        $rs = $this->db->query($sql); # Ejecuta la busqueda
        $usNivel = $rs->fields[2];
        $depOrigen = $rs->fields[3];
        $codUsOrigen = $rs->fields[4];
        $nombOringen = $rs->fields[5];
        if ($tomarNivel == "si") {
            $whereNivel = ",CODI_NIVEL=$usNivel";
        }
        $codTx = "10";

        $radicadosIn = join(",", $radicados);
        $sql = "update radicado
					set
					  CARP_CODI=$carpetaDestino
					  ,CARP_PER=$carpetaTipo
					  ,radi_fech_agend=null
					  ,radi_agend=null
					  $whereNivel
				 where RADI_NUME_RADI in($radicadosIn)";

        //$this->conn->Execute($isql);
        $rs = $this->db->query($sql); # Ejecuta la busqueda
        $retorna = 1;
        if (!$rs) {
            echo "<center><font color=red>Error en el Movimiento ... A ocurrido un error y no se ha podido realizar la Transaccion</font> <!-- $sql -->";
            $retorna = -1;
        }
        if ($retorna != -1) {

            $this->insertarHistorico($radicados, $depOrigen, $codUsOrigen, $depOrigen, $codUsOrigen, $observa, $codTx);
        }
        return $retorna;
    }

    function reasignar($radicados, $loginOrigen, $depDestino, $depOrigen, $codUsDestino, $codUsOrigen, $tomarNivel, $observa, $codTx, $carp_codi, $mailObj = null) {
        $whereNivel = "";

        $this->db->conn->SetFetchMode(ADODB_FETCH_ASSOC);

        $sql = "SELECT
				USUA_DOC
				,USUA_LOGIN
				,CODI_NIVEL
				,USUA_NOMB
                                ,USUA_EMAIL
                                ,EMAIL_NOTIF
			FROM
				USUARIO
			WHERE
				DEPE_CODI=$depDestino
				AND USUA_CODI=$codUsDestino";
        # Busca el usuairo Origen para luego traer sus datos.
        //$this->db->conn->debug=true;

        $rs = $this->db->query($sql);
        //$usNivel = $rs->fields["CODI_NIVEL"];
        //$nombreUsuario = $rs->fields["USUA_NOMB"];
        $usNivel = $rs->fields['CODI_NIVEL'];
        $nombreUsuario = $rs->fields['USUA_NOMB'];
        $docUsuaDest = $rs->fields['USUA_DOC'];
        $usuaEmail = $rs->fields["USUA_EMAIL"];
        $emailNotif = $rs->fields["EMAIL_NOTIF"];
        if ($tomarNivel == "si") {
            $whereNivel = ",CODI_NIVEL=$usNivel";
        }


        $radicadosIn = join(",", $radicados);
        $proccarp = "Reasignar";
        $carp_per = 0;
        $isql = "update radicado
				set
				  RADI_USU_ANTE='$loginOrigen'
				  ,RADI_DEPE_ACTU=$depDestino
				  ,RADI_USUA_ACTU=$codUsDestino
				  ,CARP_CODI=$carp_codi
				  ,CARP_PER=$carp_per
				  ,RADI_LEIDO=0
				  , radi_fech_agend=null
				  ,radi_agend=null
				  $whereNivel
			 where radi_depe_actu=$depOrigen
			 	   AND radi_usua_actu=$codUsOrigen
				   AND RADI_NUME_RADI in($radicadosIn)";
        //$this->conn->Execute($isql);
        $this->db->conn->Execute($isql); # Ejecuta la busqueda
        if ($codUsDestino == $codUsOrigen && $depDestino == $depOrigen) {
            $siMismo = true;
        } else {
            $siMismo = false;
        }
        if (((int) $emailNotif === 1))
        {
        	if ($mailObj && (!$siMismo) && $this->comprobar_email($usuaEmail)) {
            	$sqlRadData = "select rad.radi_nume_radi num, 
                                    rad.ra_asun asunto,
                                    tp.sgd_tpr_descrip tipo
                            from radicado rad
                            inner join sgd_tpr_tpdcumento tp on tp.sgd_tpr_codigo=rad.tdoc_codi
                            where RADI_NUME_RADI in($radicadosIn)";
            	$rsRadData = $this->db->query($sqlRadData);
	            //$rs = $this->db->conn->Execute($sql);
    	        if ($rsRadData && !$rsRadData->EOF)
        	        while ($arr = $rsRadData->FetchRow()) {
            	        $mailContent['transUpper'] = 'REASIGNACI&Oacute;N';
                	    $mailContent['to'] = $nombreUsuario;
                    	$mailContent['transLower'] = 'Reasignaci&oacute;n';
	                    $mailContent['tpDoc'] = $arr['TIPO'];
    	                $mailContent['radiNum'] = $arr['NUM'];
        	            $mailContent['asunto'] = $arr['ASUNTO'];
            	        $mailContent['comment'] = $observa;
                	    $Subject = "Reasignado de radicado " . $arr['NUM'];
	                    $this->CreateAndSend($mailObj, $usuaEmail, $nombreUsuario, $Subject, $mailContent);
    	            }
        	}
        }
        $this->insertarHistorico($radicados, $depOrigen, $codUsOrigen, $depDestino, $codUsDestino, $observa, $codTx);
        return $nombreUsuario;
    }

    //Agregado por Ing.John Guerrero, para notificaciones por correo en transacciones
    function ChC($mystring) {
        return iconv("UTF-8", "ISO-8859-1", $mystring);
    }

    function CreateAndSend($objMail, $Mailto, $MailtoNomb, $Subject, $mailContent) {
        //global $UserName, $ruta_raiz, $server_mail, $port, $Mailer, $MailerNomb, $MailerPwd;
        /*
         * $mailContent['transUpper'] 
         * $mailContent['to'] 
         * $mailContent['transLower'] 
         * $mailContent['tpDoc'] 
         * $mailContent['radiNum'] 
         * $mailContent['asunto'] 
         * $mailContent['comment']
         */
        $style = "<!DOCTYPE html>
        <html>
        <head>
        <style type = \"text/css\">
        #Warp #Body p{
        padding-left:10%;
        padding-right: 10%;
        }
        #Warp {
        width: 60%;
        margin-right: auto;
        margin-left: auto;
        border-top-style: outset;
        border-right-style: outset;
        border-bottom-style: outset;
        border-left-style: outset;
        border-top-width: thin;
        border-right-width: thin;
        border-bottom-width: thin;
        border-left-width: thin;
        family-name: \"arial\";
        }
        #Warp #title {
        text-align: center;
        color: #24748c;
        }
        </style>
        </head >";
        $preMailBody = "<body>
                            <div id=\"Warp\">
                            <img src=\"http://" . $_SERVER['SERVER_NAME'] . "/logoEntidadLogin.png\" width=\"197\" height=\"98\"/>
                            <div id=\"title\">
                            <p>NOTIFICACION DE " . $mailContent['transUpper'] . "</p>
                            </div>
                            <div id=\"Body\">
                                <p>&nbsp;</p>
                                <p>Respetad@ <b>" . $mailContent['to'] . "</b>
                            </p>
                            <p>Perm�tame comunicarle que se ha generado una transacci�n de <b>" . $mailContent['transLower'] . "</b> sobre un documento de tipo <b>" . $mailContent['tpDoc'] . "</b>, con el No. de radicado <b><a href=http://" . $_SERVER['SERVER_NAME'] . "/verradicado.php?verrad=" . $mailContent['radiNum'] . "&><span>" . $mailContent['radiNum'] . "</span></a></b>, cuyo asunto es <b>" . $mailContent['asunto'] . "</b> y sobre el cual se indica en su comentario  lo siguiente: <b>" . $mailContent['comment'] . "</b>.</p>
                            <p>Se sugiere su revisi�n lo antes posible y si desea puede acceder al sistema mediante <a href=\"http://" . $_SERVER['SERVER_NAME'] . "\" target=\"_blank\">http://" . $_SERVER['SERVER_NAME'] . "</a></p>
                            <p>&nbsp;</p>
                            </div>
                            </div>
                            </body>
                        </html>";
        /* $objMail->IsSMTP(); 
          $objMail->SMTPDebug = 1;
          $objMail->SMTPAuth = true;
          $objMail->SMTPSecure = "";
          $objMail->Host = $server_mail;
          $objMail->Port = $port;

          $objMail->Username = $UserName;
          $objMail->Password = $MailerPwd;

          $objMail->From = $Mailer;
          $objMail->FromName = $MailerNomb; */
        $MailBody = $style . $preMailBody;
        $objMail->ClearAddresses();
        $objMail->AddAddress($Mailto, $MailtoNomb);
        $objMail->Subject = $Subject;
        $objMail->AltBody = "Su visor de correos no es compatible con HTML";
        $objMail->Body = $MailBody;
        $objMail->IsHTML(true);
        try {
            $exito = $objMail->Send();
            if ($exito) {
                return "Mensaje enviado a $MailtoNomb<br>";
            } else {
                return "No enviado a $MailtoNomb <br>";
            }
        } catch (phpmailerException $e) {
            return $e->errorMessage(); //Pretty error messages from PHPMailer 
        } catch (Exception $e) {
            return $e->getMessage(); //Boring error messages from anything else! 
        }
    }

//Modificado por Fabian Mauricio Losada
    function archivar($radicados, $loginOrigen, $depOrigen, $codUsOrigen, $observa, $KeepSec = true) {
        $whereNivel = "";
        $radicadosIn = join(",", $radicados);
        $carp_codi = substr($depOrigen, 0, 2);
        $carp_per = 0;
        $carp_codi = 0;
        if (!$KeepSec) {
            $MantieneSec = ' ,SGD_SPUB_CODIGO=0 ';
        }
        //$this->db->conn->debug=true;
        $isql = "update radicado
					set
					  RADI_USU_ANTE='$loginOrigen'
					  ,RADI_DEPE_ACTU=999
					  ,RADI_USUA_ACTU=1
					  ,CARP_CODI=$carp_codi
					  ,CARP_PER=$carp_per
					  ,RADI_LEIDO=0
					  ,radi_fech_agend=null
					  ,radi_agend=null
					  ,CODI_NIVEL=1
					  $MantieneSec
				 where radi_depe_actu=$depOrigen
				 	   AND radi_usua_actu=$codUsOrigen
					   AND RADI_NUME_RADI in($radicadosIn)";
        //$this->conn->Execute($isql);
        $this->db->conn->Execute($isql); # Ejecuta la busqueda
        $this->insertarHistorico($radicados, $depOrigen, $codUsOrigen, 999, 1, $observa, 13);
        return $isql;
    }

    // Hecho por Fabian Mauricio Losada
    function nrr($radicados, $loginOrigen, $depOrigen, $codUsOrigen, $observa) {
        $whereNivel = "";
        $radicadosIn = join(",", $radicados);
        $carp_codi = substr($depOrigen, 0, 2);
        $carp_per = 0;
        $carp_codi = 0;
        //$this->db->conn->debug=true;
        $isql = "update radicado
					set
					  RADI_USU_ANTE='$loginOrigen'
					  ,RADI_DEPE_ACTU=999
					  ,RADI_USUA_ACTU=1
					  ,CARP_CODI=$carp_codi
					  ,CARP_PER=$carp_per
					  ,RADI_LEIDO=0
					  ,radi_fech_agend=null
					  ,radi_agend=null
					  ,CODI_NIVEL=1
					  ,SGD_SPUB_CODIGO=0
					  ,RADI_NRR=1
				 where radi_depe_actu=$depOrigen
				 	   AND radi_usua_actu=$codUsOrigen
					   AND RADI_NUME_RADI in($radicadosIn)";
        //$this->conn->Execute($isql);
        $this->db->conn->Execute($isql); # Ejecuta la busqueda
        $this->insertarHistorico($radicados, $depOrigen, $codUsOrigen, 999, 1, $observa, 68);
        return $isql;
    }

    /**
     * Nueva Funcion para agendar.
     * Este metodo permite programar un radicado para una fecha especifica, el arreglo con la version anterior
     * , es que no se borra el agendado cuando el radicado sale del usuario actual.
     *
     * @author JAIRO LOSADA JUNIO 2006
     * @version 3.5.1
     *
     * @param array int $radicados
     * @param varchar $loginOrigen
     * @param numeric $depOrigen
     * @param numeric $codUsOrigen
     * @param varchar $observa
     * @param date $fechaAgend
     * @return boolean
     */
    function agendar($radicados, $loginOrigen, $depOrigen, $codUsOrigen, $observa, $fechaAgend) {
        $whereNivel = "";
        $radicadosIn = join(",", $radicados);
        $carp_codi = substr($depOrigen, 0, 2);
        $carp_per = 1;
        $sqlFechaAgenda = $this->db->conn->DBDate($fechaAgend);
        $this->datosUs($codUsOrigen, $depOrigen);
        $usuaDocAgen = $this->usuaDocB;
        foreach ($radicados as $noRadicado) {
            # Busca el usuairo Origen para luego traer sus datos.
            //$this->db->conn->debug=true;
            $rad = array();
            $observa = "Agendado para el $fechaAgend - " . $observa;
            if ($usuaDocAgen) {
                $record["RADI_NUME_RADI"] = $noRadicado;
                $record["DEPE_CODI"] = $depOrigen;
                $record["SGD_AGEN_OBSERVACION"] = "'$observa '";
                $record["USUA_DOC"] = "'$usuaDocAgen'";
                $record["SGD_AGEN_FECH"] = $this->db->conn->OffsetDate(0, $this->db->conn->sysTimeStamp);
                $record["SGD_AGEN_FECHPLAZO"] = $sqlFechaAgenda;
                $record["SGD_AGEN_ACTIVO"] = 1;
                $insertSQL = $this->db->insert("SGD_AGEN_AGENDADOS", $record, "true");

                $this->insertarHistorico($radicados, $depOrigen, $codUsOrigen, $depOrigen, $codUsOrigen, $observa, 14);
            }
        }



        //$this->conn->Execute($isql);
        return $isql;
    }

    /**
     * Metodo que sirve para sacar uno o varios radicados de agendado
     *
     * @param array $radicados
     * @param unknown_type $loginOrigen
     * @param unknown_type $depOrigen
     * @param unknown_type $codUsOrigen
     * @param unknown_type $observa
     * @return unknown
     */
    function noAgendar($radicados, $loginOrigen, $depOrigen, $codUsOrigen, $observa) {
        $this->datosUs($codUsOrigen, $depOrigen);
        $usuaDocAgen = $this->usuaDocB;
        $whereNivel = "";
        $radicadosIn = join(",", $radicados);
        $carp_codi = substr($depOrigen, 0, 2);
        $isql = "update sgd_agen_agendados
					set
					  SGD_AGEN_ACTIVO=0
				 where
				   RADI_NUME_RADI in($radicadosIn)
				   AND USUA_DOC='$usuaDocAgen'";
        //$this->conn->Execute($isql);
        $this->db->conn->Execute($isql); # Ejecuta la busqueda
        $this->insertarHistorico($radicados, $depOrigen, $codUsOrigen, $depOrigen, $codUsOrigen, $observa, 15);
        return $isql;
    }

    function devolver($radicados, $loginOrigen, $depOrigen, $codUsOrigen, $tomarNivel, $observa) {
        $whereNivel = "";
        $retorno = "";
        //$this->db->conn->debug=true;
        $this->db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
        foreach ($radicados as $noRadicado) {
            $sql = "SELECT
					b.USUA_DOC
					,b.USUA_LOGIN
					,b.CODI_NIVEL
					,b.DEPE_CODI
					,b.USUA_CODI
					,b.USUA_NOMB
				FROM
					RADICADO a, USUARIO b
				WHERE
					a.RADI_USU_ANTE=b.USUA_LOGIN
					AND a.RADI_NUME_RADI = $noRadicado
                                        and b.usua_esta='1'";
            # Busca el usuairo Origen para luego traer sus datos.
            $rs = $this->db->conn->Execute($sql); # Ejecuta la busqueda
            $usNivel = $rs->fields['CODI_NIVEL'];
            $depDestino = $rs->fields['DEPE_CODI'];
            $codUsDestino = $rs->fields['USUA_CODI'];
            $nombDestino = $rs->fields['USUA_NOMB'];
            $rad = array();
            if ($codUsDestino) {
                if ($tomarNivel == "si") {
                    $whereNivel = ",CODI_NIVEL=$usNivel";
                }
                $radicadosIn = join(",", $radicados);
                $proccarp = "Dev. ";
                $carp_codi = 12;
                $carp_per = 0;
                $isql = "update radicado
						set
						  RADI_USU_ANTE='$loginOrigen'
						  ,RADI_DEPE_ACTU=$depDestino
						  ,RADI_USUA_ACTU=$codUsDestino
						  ,CARP_CODI=$carp_codi
						  ,CARP_PER=$carp_per
						  ,RADI_LEIDO=0
						  , radi_fech_agend=null
						  ,radi_agend=null
						  $whereNivel
					 where radi_depe_actu=$depOrigen
						   AND radi_usua_actu=$codUsOrigen
						   AND RADI_NUME_RADI = $noRadicado";
                $this->db->conn->Execute($isql); # Ejecuta la busqueda
                $rad[] = $noRadicado;
                $this->insertarHistorico($rad, $depOrigen, $codUsOrigen, $depDestino, $codUsDestino, $observa, 12);
                array_splice($rad, 0);
                $retorno = $retorno . "$noRadicado ------> $nombDestino <br>";
            } else {
                $retorno = $retorno . "<font color=red>$noRadicado ------> Usuario Anterior no se encuentra o esta inactivo</font><br>";
            }
        }
        return $retorno;
    }

    function verficaNivel($rads, $nivel = 0) {
        if (is_array($rads)) {
            $radicadosIn = implode(',', $rads);
        } else {
            $radicadosIn = $rads;
        }
        $sql = "select distinct radi_nume_radi from radicado where sgd_spub_codigo=$nivel and radi_nume_radi in ($radicadosIn)";
        $rs = $this->db->conn->Execute($sql);
        $i = 0;
        while (!$rs->EOF) {
            $i > 0 ? $car = ',' : '';
            $radicados .= $car . $rs->fields['RADI_NUME_RADI'];
            $rs->MoveNext();
            $i++;
        }
        return $radicados;
    }
    /**
     * Funcion extraida de una de las funcionalidades del servicio WEB expuesto carpeta(WS) server.php.
     * @param type $email
     * @return boolean
     */
    function comprobar_email($email, $esRequerido)
    {
        $mail_correcto = 0;
        if($esRequerido){
            if(trim($email) == ''){
              return 0;  
            } 
        }
        //compruebo unas cosas primeras
        if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@"))
        {
            if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"$")) && (!strstr($email," ")))
            {   //miro si tiene caracter .
                if (substr_count($email,".")>= 1)
                {   //obtengo la terminacion del dominio
                    $term_dom = substr(strrchr ($email, '.'),1);
                    //compruebo que la terminacion del dominio sea correcta
                    if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) )
                    {   //compruebo que lo de antes del dominio sea correcto
                        $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                        $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                        if ($caracter_ult != "@" && $caracter_ult != ".")
                        {
                            $mail_correcto = 1;
       }    }   }   }   }
       
        if ($mail_correcto==1)
           return true;
        else
           return false;
    }

}

?>
