<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of claseformunlario
 *
 * @author Julian Andres Ortiz Moreno
 */
$ruta_raiz = "../..";
   
    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
    include_once($ruta_raiz."/include/PHPMailer_v5.1/class.phpmailer.php");
    

include 'adjuntarArchivos.php';
define('ADODB_FETCH_ASSOC',2);
class claseformunlario {
    //put your code here
    var $db;
    var $uploader;
    var $files;
    var $mail;
    var $rutaraiz;
    var $usuariopqr;
    var $dependencia;
    public function __construct($ruta_raiz,$files) {
        $this->db = new ConnectionHandler($ruta_raiz);
        $this->uploader = new Uploader($files);
	$this->files = $files;
       
        $this->rutaraiz = $ruta_raiz;
    }
    function crearCiudadano($tipoid,
                            $primernombre,
                            $segunnombre,
                            $direcion,
                            $primerapellido,
                            $segundoapellido,
                            $telefonooficina,
                            $telefonomovil,
                            $email,
                            $munisipioresi,
                            $departamentoresi,
                            $numid,
                            $continenteresi,
                            $paisresi,$fax,$idcargo,$idprofesion)
    {
                    $num_ciu=$this->db->conn->GenID('SEC_CIU_CIUDADANO');
                
                    $ciudadano = array('TDID_CODI'=>"'".$tipoid."'",
                   'SGD_CIU_CODIGO'=>"'".$num_ciu."'",
                   'SGD_CIU_NOMBRE'=>"'".$primernombre." ".$segunnombre."'",
                   'SGD_CIU_DIRECCION'=>"'".$direcion."'",
                   'SGD_CIU_APELL1' => "'".$primerapellido."'",
                   'SGD_CIU_APELL2'=>"'".$segundoapellido."'",
                   'SGD_CIU_TELEFONO'=>"'".$telefonooficina." /".$telefonomovil."'",
                   'SGD_CIU_EMAIL'=>"'".$email."'",
                   'MUNI_CODI'=>"'".$munisipioresi."'",
                   'DPTO_CODI'=>"'".$departamentoresi."'",
                   'SGD_CIU_CEDULA'=>"'".$numid."'",
                   'ID_CONT'=>"'".$continenteresi."'",
                   'ID_PAIS'=>"'".$paisresi."'",
                   'SGD_CIU_ACT'=>1,
                   'FAX'=>"'".$fax."'",
                   'IDCARGO' =>"'".$idcargo."'",
                   'IDPROFESION' => "'".$idprofesion."'");
                    
             $this->db->insert('SGD_CIU_CIUDADANO', $ciudadano);
             
             return $num_ciu;
    }
    function crearEmpresa($tipoid,$paisresi,$primernombre,$numid,$munisipioresi,$departamentoresi,$direcion,$telefonooficina,$telefonomovil)
    {
        $num_oem=$this->db->conn->GenID('SEC_OEM_OEMPRESAS');
            //insertar empresa en sgc_oem_empresas
           $empresa = array('SGD_OEM_CODIGO'=>"'".$num_oem."'",
                            'TDID_CODI'=>"'".$tipoid."'",
                            'SGD_OEM_OEMPRESA'=>"'".$primernombre."'",
                            'SGD_OEM_REP_LEGAL'=>"''",
                            'SGD_OEM_NIT'=>"'".$numid."'",
                            'SGD_OEM_SIGLA'=>"''",
                            'MUNI_CODI'=>"'".$munisipioresi."'",
                            'DPTO_CODI'=>"'".$departamentoresi."'",
                            'SGD_OEM_DIRECCION'=>"'".$direcion."'",
                            'SGD_OEM_TELEFONO'=>"'".$telefonooficina." /".$telefonomovil."'",
                            'ID_CONT'=>"'".$continenteresi."'",
                            'ID_PAIS'=>"'".$paisresi."'",
                            'SGD_OEM_ACT'=>1);

            $this->db->insert('SGD_OEM_OEMPRESAS', $empresa);
            return $num_oem;
    }
    function direciones($num_dir,$num_oem,$num_ciu,$numeroRadicado,$munisipioresi,$departamentoresi,$direcion,$primernombre,$segunnombre,
                        $primerapellido,$segundoapellido,$sgdttrcodigo,$numid,
            $paisresi,$continenteresi,$email,$idcontc,$idpaisc,$dptocodic,$municodic,$direcionc,
            $emailc,$telelc,$celularc)
    {
        $num_dir=$this->db->conn->GenID('SEC_DIR_DIRECCIONES');
        
        $arrsgddireicones=array('SGD_DIR_CODIGO'=>"'".$num_dir."'",
                                'SGD_DIR_TIPO'=>1,
                                'SGD_OEM_CODIGO'=>"'".$num_oem."'",
                                'SGD_CIU_CODIGO'=>"'".$num_ciu."'",
                                'RADI_NUME_RADI'=>"'".$numeroRadicado."'",
                                'SGD_ESP_CODI'=>0,
                                'MUNI_CODI'=>"'".$munisipioresi."'",
                                'DPTO_CODI'=>"'".$departamentoresi."'",
                                'SGD_DIR_DIRECCION'=>"'".$direcion."'",
                                'SGD_SEC_CODIGO'=>0,       
                                'SGD_TEMPORAL_NOMBRE'=>"'".$primernombre." ".$segunnombre." ".$primerapellido." ".$segundoapellido."'",
                                'SGD_DIR_NOMBRE'=>"'".$primernombre." ".$segunnombre." ".$primerapellido." ".$segundoapellido."'",
                                'SGD_DIR_NOMREMDES'=>"'".$primernombre." ".$segunnombre." ".$primerapellido." ".$segundoapellido."'",
                                'SGD_TRD_CODIGO'=>"'".$sgdttrcodigo."'",
                                'SGD_DIR_DOC'=>"'".$numid."'",
                                'ID_PAIS'=>"'".$paisresi."'",
                                'ID_CONT'=>"'".$continenteresi."'",
                                'SGD_DIR_MAIL' => "'".$email."'",
                                'ID_CONTC'=>"'".$idcontc."'",
                                'ID_PAISC' => "'".$idpaisc."'",
                                'DPTO_CODIC' => "'".$dptocodic."'",
                                'MUNI_CODIC' => "'".$municodic."'",
                                'DIRECIONC' => "'".$direcionc."'",
                                'EMAILC'=>"'".$emailc."'",
                                'TELELC' => "'".$telelc."'",
                                'CELULARC' => "'".$celularc."'");
    
              $this->db->insert("SGD_DIR_DRECCIONES", $arrsgddireicones);
              return $num_dir;
    }



   
    function crearAnexos($anexradinume,$anexcodigo,$anextipo,$anextamano,$anexsololect,$anexcreador,$anexdesc,$anexnumero,$anexnombarchivo,$anexborrado,
            $anexorigen,$anexsalida,$anexestado,$sgdremdestino,$sgddirtipo,$anexdepecredor,$anexfechanex,$sgdaplicodi)
    {
        
         $arraanexos=array(
                            'ANEX_RADI_NUME'=>"'".$anexradinume."'",
                            'ANEX_CODIGO'=>"'".$anexcodigo."'",
                            'ANEX_TIPO'=>"'".$anextipo."'",
                            'ANEX_TAMANO'=>"'".$anextamano."'",
                            'ANEX_SOLO_LECT'=>"'".$anexsololect."'",
                            'ANEX_CREADOR'=>"'".$anexcreador."'",
                            'ANEX_DESC'=>"'".$anexdesc."'",
                            'ANEX_NUMERO'=>"'".$anexnumero."'",
                            'ANEX_NOMB_ARCHIVO'=>"'".$anexnombarchivo."'",
                            'ANEX_BORRADO'=>"'".$anexborrado."'",
                            'ANEX_ORIGEN'=>"'".$anexorigen."'",
                            'ANEX_SALIDA'=>"'".$anexsalida."'",
                            'ANEX_ESTADO'=>1,
                            'SGD_REM_DESTINO'=>"'".$sgdremdestino."'",
                            'SGD_DIR_TIPO'=>"'".$sgddirtipo."'",
                            'ANEX_DEPE_CREADOR'=>"'".$anexdepecredor."'",
                            'ANEX_FECH_ANEX'=>$this->db->conn->OffsetDate(0,$this->db->conn->sysTimeStamp),
                            'SGD_APLI_CODI'=>1);
			
                            $this->db->insert("ANEXOS",$arraanexos);
    }
    
    function obtenerNumberoRadicada($tpRad,$tpdeperad,$numdigitos)
    {
        $SecName = "SECR_TP$tpRad"."_".$tpDepeRad;
        $secNew=$this->db->conn->nextId($SecName);
        $newRadicado = 0;
        if($secNew==0)
        {
                $this->db->conn->RollbackTrans();
                $secNew=$this->db->conn->nextId($SecName);
                if($secNew==0) die("<hr><b><font color=red><center>Error no genero un Numero de Secuencia<br>SQL: $secNew</center></font></b><hr>");
                
        }
        else
        {
             $newRadicado = date("Y") .str_pad($tpdeperad,3,"0", STR_PAD_LEFT). str_pad($secNew,$numdigitos,"0", STR_PAD_LEFT) . $tpRad;

        }
        return $newRadicado;
        
    }
    
    function cargarArchivos($dependencia,$numeroRadicado,$adjuntosSubidos)
    {  
        $this->uploader->FILES = $this->files;
	$adjuntosSubidos = json_decode($adjuntosSubidos);
	$this->uploader->subidos = $adjuntosSubidos;
        
	$this->uploader->adjuntarYaSubidos();
        
       
        $this->uploader->bodega_dir .= date('Y') . "/" .$dependencia. "/docs/";
        
	$this->uploader->moverArchivoCarpetaBodegaYaSubidos($numeroRadicado);
        
    }
    
    function updateRadicado($asuntopqr,$tipopqr,$numeroRadicado,$pach,$tipoid)
    {   
        if($tipoid != 4):
            $Tercero = 0;
            
        else:
            $Tercero = 2;
            
        endif;
        $array = array('ASUNTOPQR'=>"'".$asuntopqr."'",
            'TIPOPQR'=>"'".$tipopqr."'",'RADI_PATH'=>"'".$pach."'",
            'SGD_APLI_CODIGO'=>1,
            'TRTE_CODI'=>$Tercero,'FLAG_NIVEL'=>1);
        $this->db->update("RADICADO", $array,array('RADI_NUME_RADI'=>"'".$numeroRadicado."'"));
    }
    
    function AnexarArchivos($numeroRadicado,$depecreador,$usuariopqr)
    {
        $candtidadadjuntos = 0;
            $sql_login="select usua_login from usuario where usua_codi=".$usuariopqr." and depe_codi=".$depecreador;
           $rs_login=$this->db->conn->Execute($sql_login);
          
	    if($this->uploader->tieneArchivos){	
                
		for($i=0; $i < count($this->uploader->subidos);$i++)
		{
                     
			if(strlen($this->uploader->subidos[$i]) == 0){
				continue;
			}
			$candtidadadjuntos = $candtidadadjuntos + 1;
			$extension = strtolower(end(explode('.',$this->uploader->subidos[$i])));
			$sql_tipoAnex = "select anex_tipo_codi from anexos_tipo where anex_tipo_ext = '".$extension ."'";
			$rs_tipoAnexo = $this->db->conn->Execute($sql_tipoAnex);
			$tipoCodigo =24;
                        
			if(!$rs_tipoAnexo->EOF){
				$tipoCodigo = $rs_tipoAnexo->fields["ANEX_TIPO_CODI"];
                                
			}else {
				$sql_tipoAnex = "select anex_tipo_codi from anexos_tipo where anex_tipo_ext = '*'";
				$rs_tipoAnexo = $this->db->conn->Execute($sql_tipoAnex);
				if(!$rs_tipoAnexo->EOF){
					$tipoCodigo = $rs_tipoAnexo->fields["ANEX_TIPO_CODI"];
				}
                                
			}
                        
                        
                        
                        $this->crearAnexos($numeroRadicado, $numeroRadicado.sprintf("%05d",($i+1)), 
                                           $tipoCodigo, $this->uploader->sizes[$i],
                                           "S", $rs_login->fields['USUA_LOGIN'],
                                           $this->uploader->sha1sums[$i],1,$this->uploader->nombreOrfeo[$i],
                                           "N",0,0,
                                           0,1,
                                           1,$depecreador,
                                           "CURRENT_TIMESTAMP",0);
//                        
			
		}
	}
        
        
    }
    
    
    function asignarMTRD($codigoPqr,$dependencia,$numeroR,$usuariopqr)
        {
             $sql_login="select USUA_DOC from usuario where usua_codi=".$usuariopqr." and depe_codi=".$dependencia;
             $rs_login=$this->db->conn->Execute($sql_login);
           
            $sql= "select serie,subserie,tipodocumen from formulariopqr where ID = ".$codigoPqr;
            $resultado=$this->db->query($sql);
            
            $sql="select SGD_MRD_CODIGO from SGD_MRD_MATRIRD
            where DEPE_CODI ='$dependencia' and SGD_SRD_CODIGO = '".$resultado->fields['SERIE']."' and
            SGD_SBRD_CODIGO = '".$resultado->fields['SUBSERIE']."' and SGD_TPR_CODIGO = '".$resultado->fields['TIPODOCUMEN']."'";
            
            $reulw = $this->db->query($sql);
            
            $arraytrd = array('SGD_MRD_CODIGO'=>"'".$reulw->fields['SGD_MRD_CODIGO']."'",
                'RADI_NUME_RADI'=>"'".$numeroR."'",'DEPE_CODI'=>"'".$dependencia."'",
                'USUA_CODI' => "'".$usuariopqr."'",'USUA_DOC'=>"'".$rs_login->fields['USUA_DOC']."'",
                'SGD_RDF_FECH'=>$this->db->conn->OffsetDate(0,$this->db->conn->sysTimeStamp));
            $this->db->insert("SGD_RDF_RETDOCF", $arraytrd);
        }
    
         function enviarcorreo($mensaje,$correo,$rutaPdf,$tema,$formulario)
                {  
                   $sql = "select nombre from asunto where id=".$tema;
                   $resul=$this->db->conn->Execute($sql);
                   
                   $sql = "select nombre from FORMULARIOPQR where id = $formulario";
                   $pqr=$this->db->conn->Execute($sql);
                   
                   $consultaUsuario="SELECT USUA_NOMB,USUA_CODI,DEPE_CODI,USUA_EMAIL FROM USUARIO
                    WHERE USUA_ESTA = 1 and USUA_EMAIL is not null and USUA_PERM_ENVIOS != 0 AND USUA_CODI = ".$this->usuariopqr." AND DEPE_CODI=".$this->dependencia;
                  
                   $usuario = $this->db->conn->Execute($consultaUsuario);
                   
                    require_once("configPHPMailer.php");
                    $mail = new PHPMailer();
                    $usMailSelect  = $admPHPMailer; 
                    $mail->IsSMTP(); // telling the class to use SMTP
                    $mail->AddReplyTo($usMailSelect);
                    $mail->SetFrom($usMailSelect,"PQRS sgc");
                    $mail->Host       = $hostPHPMailer;
                    $mail->Port       = $portPHPMailer;
                    $mail->SMTPDebug  = 0;  // 1 = errors and messages // 2 = messages only 
                    $mail->SMTPAuth   = "true";
                    $mail->SMTPSecure = "tls";
                    $mail->AuthType   = $tipoAutenticacion;
                    $mail->Username   = $userPHPMailer;   // SMTP account username
                    $mail->Password   = $passwdPHPMailer; // SMTP account password
                    $mail->Subject    = $pqr->fields['NOMBRE']."/".$resul->fields['NOMBRE'];
                    $mail->AltBody    = "Para ver el mensaje, por favor use un visor de E-mail compatible!";
                    $mail->AddBCC($usuario->fields['USUA_EMAIL'], $usuario->fields['USUA_NOMB']);
                    $url=true;
                    $mail->AddAttachment("$this->rutaraiz/poolsgc2013/$rutaPdf");
                    $mail->AddAddress($correo);
                    $asu .= "<hr>Sistema de gestion Orfeo. http://www.sgc.gov.co";
                    
                    $mail->MsgHTML($mensaje);
                            
                    if ($mail->Send()) {
 
                    }
                }
                    
}

