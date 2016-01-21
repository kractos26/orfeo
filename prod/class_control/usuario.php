<?php 
/**
 * Usuario es la clase encargada de gestionar las operaciones y los datos b�sicos referentes a un usuario
 * @author	Sixto Angel Pinz�n
 * @version	1.0
 */
class Usuario {
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var numeric
   * @access public
   */
var $depe_codi;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var numeric
   * @access public
   */
var $usua_codi;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usua_pasw;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usua_nomb;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $perm_radi;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usua_nuevo;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usua_doc;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usua_nacim;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usua_email;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var numeric
   * @access public
   */
var $perm_radi_sal;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usu_direccion;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usu_telefono1;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var string
   * @access public
   */
var $usu_telefono2;
/**
   * Variable que se corresponde con su par, uno de los campos de la tabla usuario
   * @var numeric
   * @access public
   */
var $usu_cargo;
/**
   * Gestor de las transacciones con la base de datos
   * @var ConnectionHandler
   * @access public
   */
var $cursor;

/**
 * Variable que contiene el permiso de si un usuario puede tipificar un anexo .tiff
 *
 * @var Number
 */

var $perm_tipif_anexo;

/**
 * Variable que contiene el permiso de si un uusairo puede borrar un anexo .tiff
 *
 * @var number
 */

var $perm_borrar_anexo;

  
/** 
* Constructor encargado de obtener la conexion
* @param	$db	ConnectionHandler es el objeto conexion
* @return   void
*/
function Usuario($db) {
	
	$this->cursor = & $db;

}


/** 
  * Carga los datos de la instacia con con  referencia a un login de usuario suministrado retorna falso si no lo encuentra, de lo contrario true
  * @param	$codigo	string es el c�digo del departamento
	* @return   boolean
  */
function usuarioLogin($login) {
	$q="select *,usuario.USUA_NOMB
					,usuario.DEPE_CODI
					,usuario.USUA_NUEVO
					,usuario.USUA_DOC
					,usuario.PERM_RADI
					,usuario.USUA_EMAIL
					,usuario.USUA_NACIM from usuario where usua_login='$login' ";
	$rs=$this->cursor->query($q);
	
	if 	 ($rs && !$rs->EOF){
		   $this->depe_codi=$rs->fields['DEPE_CODI'];
			 $this->usua_pasw=$rs->fields['USUA_PASW'];
			 $this->usua_nomb=$rs->fields['USUA_NOMB'];
			 $this->perm_radi=$rs->fields['PERM_RADI'];
			 $this->usua_nuevo=$rs->fields['USUA_NUEVO'];
			 $this->usua_doc=$rs->fields['USUA_DOC'];
			 $this->usua_nacim=$rs->fields['USUA_NACIM'];
			 $this->usua_email=$rs->fields['USUA_EMAIL'];
			 $this->perm_radi_sal=$rs->fields['PERM_RADI_SAL'];
			 $this->usu_direccion=$rs->fields['USU_DIRECCION'];
			 $this->usu_telefono1=$rs->fields['USU_TELEFONO1'];
			 $this->usu_telefono2=$rs->fields['USU_TELEFONO2'];
			 $this->usu_cargo=$rs->fields['USU_CARGO'];
			 $this->perm_tipif_anexo=$rs->fields['PERM_TIPIF_ANEXO'];
			 return true;
		}else
			 return false;
		
}


/** 
  * Carga los datos de la instacia con con  referencia a un codigo de dependencia y un codigo de usuario suministrado retorna falso si no lo encuentra, de lo contrario true
  * @param	$dependencia	string es el c�digo de la dependencia
	* @param	$codUsuario	string es el c�digo del usuario
	* @return   boolean
  */
function usuarioDependecina($dependencia,$codUsuario) {
	$q="select *
					,usuario.USUA_NOMB
					,usuario.DEPE_CODI
					,usuario.USUA_NUEVO
					,usuario.USUA_DOC
					,usuario.PERM_RADI
					,usuario.USUA_EMAIL
					,usuario.USUA_NACIM
					 from usuario where depe_codi = $dependencia and usua_codi = $codUsuario ";
	$rs=$this->cursor->query($q);
	
	if 	 ($rs && !$rs->EOF){
		   $this->depe_codi=$rs->fields['DEPE_CODI'];
			 $this->usua_pasw=$rs->fields['USUA_PASW'];
			 $this->usua_nomb=$rs->fields['USUA_NOMB'];
			 $this->perm_radi=$rs->fields['PERM_RADI'];
			 $this->usua_nuevo=$rs->fields['USUA_NUEVO'];
			 $this->usua_doc=$rs->fields['USUA_DOC'];
			 $this->usua_nacim=$rs->fields['USUA_NACIM'];
			 $this->usua_email=$rs->fields['USUA_EMAIL'];
			 $this->perm_radi_sal=$rs->fields['PERM_RADI_SAL'];
			 $this->usu_direccion=$rs->fields['USU_DIRECCION'];
			 $this->usu_telefono1=$rs->fields['USU_TELEFONO1'];
			 $this->usu_telefono2=$rs->fields['USU_TELEFONO2'];
			 $this->usu_cargo=$rs->fields['USU_CARGO'];
			 $this->perm_tipif_anexo=$rs->fields['PERM_TIPIF_ANEXO'];
			 return true;		
		}else
			 return false;
}

/** 
* Genera el javascript que ha de permitir llenar un combo con los usuarios de cierta dependencia
* @return   void
*/
function comboUsuarioDependencia() {
 echo " function comboUsuarioDependencia(forma,dependencia,combo)";
        echo "{";
			 //   echo " alert ('entra a nivel educativo']; ";
				echo "o = new Array;";
				echo "i=0;";
			//	 echo " o[i++]=new Option('----- seleccione -----', 'null',true,true); ";


     $dbsql2=" SELECT usuario.*,dependencia.depe_nomb  FROM usuario,dependencia where usuario.depe_codi = dependencia.depe_codi ";
		 $rs=$this->cursor->query($dbsql2);

          while	($rs && !$rs->EOF)
			{

			echo " if (dependencia == ". $rs->fields['DEPE_CODI'] . " )  ";

			$descripcion = chop ($rs->fields['USUA_NOMB']);
			$descripcion=str_replace("'", "", $descripcion);
			echo "o[i++]=new Option('$descripcion','". $rs->fields['USUA_CODI'] ."' );";
			$rs->MoveNext();



          }








        echo " largestwidth=0; ";
        echo " for (i=0; i < o.length; i++) ";
        echo " { ";
	 // echo "  alert( '!!!entra1!!!'];";
        echo "   eval(forma.elements[combo].options[i+1]=o[i]); ";
 	 // echo "  alert( '!!!entra2!!!'];";

        echo "   if (o[i].text.length > largestwidth) ";
			  echo "   { ";
        echo "     largestwidth=o[i].text.length; ";
			  echo " }  ";
        echo " } ";
 echo " eval(forma.elements[combo].length=o.length+1); ";

			echo " } ";




}


/** 
* Genera el javascript que ha de permitir llenar un combo con los usuarios de cierta dependencia de un gupo de dependencias establecidas por el paramentro enviado a la funci�n
* @param $dependencias  es el grupo de dependencias establecido
* @return   void
*/
function comboUsDepGrp($dependencias) {
 $stringDeps= implode ( ",", $dependencias );
 echo " function comboUsuarioDependencia(forma,dependencia,combo)";
        echo "{";
			 //   echo " alert ('entra a nivel educativo']; ";
				echo "o = new Array;";
				echo "i=0;";
			//	 echo " o[i++]=new Option('----- seleccione -----', 'null',true,true); ";

     // $this->cursor->conn->debug=true;
     $dbsql2=" SELECT usuario.*,dependencia.depe_nomb  FROM usuario,dependencia where usuario.depe_codi = dependencia.depe_codi and usuario.depe_codi in($stringDeps)";
		 $rs=$this->cursor->query($dbsql2);


          while	($rs && !$rs->EOF)
			{

			echo " if (dependencia == ". $rs->fields['DEPE_CODI'] . " )  ";

			$descripcion = chop ($rs->fields['USUA_NOMB']);
			$descripcion=str_replace("'", "", $descripcion);
			echo "o[i++]=new Option('$descripcion','". $rs->fields['USUA_CODI'] ."' );";
			$rs->MoveNext();

          }

        echo " largestwidth=0; ";
        echo " for (i=0; i < o.length; i++) ";
        echo " { ";
	 // echo "  alert( '!!!entra1!!!'];";
        echo "   eval(forma.elements[combo].options[i+1]=o[i]); ";
 	 // echo "  alert( '!!!entra2!!!'];";

        echo "   if (o[i].text.length > largestwidth) ";
			  echo "   { ";
        echo "     largestwidth=o[i].text.length; ";
			  echo " }  ";
        echo " } ";
 echo " eval(forma.elements[combo].length=o.length+1); ";

			echo " } ";




}


/** 
* Genera el javascript que ha de permitir llenar un combo con los usuarios de cierta dependencia de un gupo de dependencias establecidas por el paramentro enviado a la funci�n, haciendo uso del par�metrop where que llega y que filtra ciera caracter�atica del usuario a seleccioner
* @param $dependencias  es el grupo de dependencias establecido
* @param $where	es el criterio de filtro para los usuarios de las dependencias seleccionadas
* @return   void
*/
function comboUsDepsWhr($dependencias, $whereFilt) {
  
$whereDeps = "";
if (count($dependencias) > 0){
 	 $stringDeps= implode ( ",", $dependencias );
 	 $whereDeps = " and usuario.depe_codi in($stringDeps) ";
 }
 echo " function comboUsuarioDependencia(forma,dependencia,combo)";
        echo "{";
			 //  echo " alert ('entra ' +  dependencia + '  ' +  combo); ";
				echo "o = new Array;";
				echo "i=0;";
			//	 echo " o[i++]=new Option('----- seleccione -----', 'null',true,true); ";

     // $this->cursor->conn->debug=true;
     $dbsql2=" SELECT usuario.*,dependencia.depe_nomb  FROM usuario,dependencia where 
                
     			usuario.depe_codi = dependencia.depe_codi  $whereDeps $whereFilt";
		 $rs=$this->cursor->query($dbsql2);


          while	($rs && !$rs->EOF)
			{

			echo " \n if (dependencia == ". $rs->fields['DEPE_CODI'] . " )  ";

			$descripcion = chop ($rs->fields['USUA_NOMB']);
			$descripcion=str_replace("'", "", $descripcion);
			echo "o[i++]=new Option('$descripcion','". trim($rs->fields['USUA_DOC']) ."' );";
			$rs->MoveNext();

          }

        echo " largestwidth=0; ";
        echo " for (i=0; i < o.length; i++) ";
        echo " { ";
	 // echo "  alert( '!!!entra1!!!');";
        echo "   eval(forma.elements[combo].options[i]=o[i]); ";
 	 // echo "  alert( '!!!entra2!!!'];";

        echo "   if (o[i].text.length > largestwidth) ";
			  echo "   { ";
        echo "     largestwidth=o[i].text.length; ";
			  echo " }  ";
        echo " } ";
        echo  (" if (o.length == 0 ) { " );
        echo  (" o[0]=new Option('----- Sin datos -----', 'null'); " );
        echo "  eval(forma.elements[combo].options[i]=o[i]); } ";
 echo " eval(forma.elements[combo].length=o.length); ";
 

			echo " } ";




}




/** 
  * Inserta un nuevo usuario en la tabla usuario
  * @param	$values	array	es el arreglo de valores a insertar, cada el elemento de arreglo esta estructurado de la forma  Array ( [NOMBRE CAMPO] => VALOR )
  * @return   void
	*/

function insertar($values) {
	$rs=$this->cursor->insert("usuario",$values);
	
	if (!$rs){
			$db->conn->RollbackTrans();
			die ("<span class='etextomenu'>No se ha podido insertar usuario usuario "); 
	}
     
}


/** 
* Retorna el valor  correspondiente al atributo numero del documento del usuario, debe invocarse antes usuarioLogin() o usuarioDependecina
* @return   string
*/
function get_usua_doc() {
	return $this->usua_doc;
}


/** 
* Retorna el valor  correspondiente al atributo nombre del usuario, debe invocarse antes usuarioLogin() o usuarioDependecina
* @return   string
*/
function get_usua_nomb() {
	return $this->usua_nomb;

}


/** 
* Carga los datos de la instacia con con  referencia a
* un documento de usuario suministrado
* @param $docto  es el documento del usuario
* @return   void
*/
function usuarioDocto($docto) 
{
	global $ADODB_COUNTRECS;
	$ADODB_COUNTRECS = true;
	$q="select * from usuario where USUA_DOC ='$docto' ";
	$rs=$this->cursor->query($q);
	$ADODB_COUNTRECS = false;
	if 	($rs->RecordCount() >0)
	{	$this->depe_codi=$rs->fields['DEPE_CODI'];
		$this->usua_pasw=$rs->fields['USUA_PASW'];
		$this->usua_nomb=$rs->fields['USUA_NOMB'];
		$this->perm_radi=$rs->fields['PERM_RADI'];
		$this->usua_nuevo=$rs->fields['USUA_NUEVO'];
		$this->usua_doc=$rs->fields['USUA_DOC'];
		$this->usua_nacim=$rs->fields['USUA_NACIM'];
		$this->usua_email=$rs->fields['USUA_EMAIL'];
		$this->perm_radi_sal=$rs->fields['PERM_RADI_SAL'];
		$this->usu_direccion=$rs->fields['USU_DIRECCION'];
		$this->usu_telefono1=$rs->fields['USU_TELEFONO1'];
		$this->usu_telefono2=$rs->fields['USU_TELEFONO2'];
		$this->usu_cargo=$rs->fields['USU_CARGO'];
		$this->usua_codi=$rs->fields['USUA_CODI'];	
		$this->perm_tipif_anexo=$rs->fields['PERM_TIPIF_ANEXO'];
	}
}

/** 
* Limpia los atributos de la instancia referentes a la informaci�n del usuario
* @return   void
*/
function limpiarAtributos(){

	   $this->depe_codi="";
		 $this->usua_pasw="";
		 $this->usua_nomb="";
		 $this->perm_radi="";
		 $this->usua_nuevo="";
		 $this->usua_doc="";
		 $this->usua_nacim="";
		 $this->usua_email="";
		 $this->perm_radi_sal="";
		 $this->usu_direccion="";
		 $this->usu_telefono1="";
		 $this->usu_telefono2="";
		 $this->usu_cargo="";
		 $this->perm_tipif_anexo="";
}


function usuaDepSeguridadRad($dependencias, $rad)
{
  
	if(is_array($dependencias))$stringDeps= implode ( " ", $dependencias );
	else $stringDeps=  $dependencias ;
	$dbsql2=" SELECT usua_nomb, usua_login  
			  FROM   usuario 
			  WHERE  depe_codi in($stringDeps) and usua_login not in (select usua_login from sgd_matriz_nivelrad where radi_nume_radi=$rad)
			  ORDER BY 1";
	$rs=$this->cursor->query($dbsql2);
	if($rs && !$rs->EOF)
	{
		$combo=$rs->GetMenu2('selUsuPriv[]',$usDefault,false,true,3," id='selUsuPriv[]' class='select' ");
	
    }
	return $combo;	
}

function usuaDepSeguridadExp($dependencias, $exp, $usuSel=null)
{
  
	if(is_array($dependencias))$stringDeps= implode ( " ", $dependencias );
	else $stringDeps=  $dependencias ;
	if($usuSel)$usuarios=explode(",",$usuSel);
	$dbsql2=" SELECT usua_nomb, usua_login  
			  FROM   usuario 
			  WHERE  depe_codi in($stringDeps) and usua_login not in (select usua_login from sgd_matriz_nivelexp where sgd_exp_numero='$exp')
			  ORDER BY 1";
	$rs=$this->cursor->query($dbsql2);
	if($rs && !$rs->EOF)
	{
		$combo="<select name='selUsuPriv[]' id='selUsuPriv[]' size='3' class='select' multiple  onchange='usuaSel()'>";
		while(!$rs->EOF)
		{
			if(is_array($usuarios))in_array($rs->fields['USUA_LOGIN'],$usuarios)?$estDep='selected':$estDep='';
			$combo.="<option value=".$rs->fields['USUA_LOGIN']." $estDep >".$rs->fields['USUA_NOMB']."</option>";
			$rs->MoveNext();
		}
		$combo.="</select>";
		
		//$combo=$rs->GetMenu2('selUsuPriv[]',$usDefault,false,true,3," id='selUsuPriv[]' class='select' ");
		$combo.="3";
    }
	return $combo;	
}

function borraUsuSeguridadExp($login, $exp)
{
	$sqlDel="delete from sgd_matriz_nivelexp where usua_login='$login' and sgd_exp_numero='$exp'";
	$rs1=$this->cursor->conn->Execute($sqlDel);
  	return $rs1;	
}

function tblUsuSeguridadExp( $exp)
{
	$sql="select u.usua_nomb, d.depe_nomb, 
					case u.usua_codi 
					when 1 then 'Jefe' 
					else        'Normal'
					end as \"PERFIL\",
					u.usua_login 
			  from sgd_matriz_nivelexp m
			  join usuario u on u.usua_login=m.usua_login
			  join dependencia d on d.depe_codi=u.depe_codi
			  where m.sgd_exp_numero='$exp'
			  order by 2,1";
		$rs=$this->cursor->conn->Execute($sql);
		if($rs && !$rs->EOF)
		{
			$usuariosNv= "<table width='100%' align='center' class='borde_tab' >
							<tr>
								<td class='titulos2'>Usuario</td>
								<td class='titulos2'>Dependencia</td>
								<td class='titulos2'>Perfil</td>
								<td class='titulos2'>Accion</td>
							</tr>";
			
			while(!$rs->EOF)
		    {
		    	$usuariosNv .="   <tr>
		        	                  <td  class='listado2'>
		                              <font size=1>".
		                              $rs->fields["USUA_NOMB"].
		                              "</font>
		                              </td>
		                              <td class='listado2'>&nbsp;
		                              <font size=1>".
		                                $rs->fields["DEPE_NOMB"]." ".
		                              "</font>
		                             </td>
		                              <td  class='listado2'>&nbsp;
		                              <font size=1>".
		                                 $rs->fields["PERFIL"]."&nbsp;
		                              </font>
		                              <td  align='center' class='listado2'>&nbsp;
		                              <font size=1>
		                    	   	  <a href=\"javascript:verUsuarios('$exp','4','".$rs->fields["USUA_LOGIN"]."')\">Borrar</a>
		                       		  </font>
		                              </td>
		                           </tr>";
				$rs->MoveNext();
		    }
		    $usuariosNv .="</table>";       
		}
		$usuariosNv.="4"; 
  	return $usuariosNv;	
}

function usuarioDep($dependencia)
{
  
	$dbsql2=" SELECT usua_nomb, usua_login  
			  FROM   usuario 
			  WHERE  depe_codi=$dependencia order by 1";
	$rs=$this->cursor->query($dbsql2);
	if($rs && !$rs->EOF)
	{
		$combo=$rs->GetMenu2('selUsu',$Default,"0:-TODOS LOS USUARIOS-",false," id='selUsuPriv[]' class='select' ");
	
    }
	return $combo;	
}

function validaUsuario($krd,$drd)
{
	$dbsql2=" SELECT USUA_PASW, USUA_LOGIN  
			  FROM   usuario 
			  WHERE  usua_login='$krd'";
	$rs=$this->cursor->query($dbsql2);
	$band="0";
	if($rs && !$rs->EOF)
	{
		if(substr(md5($drd),1,26)==$rs->fields['USUA_PASW'])
		$band="1";
    }
	return $band;	
}

function validaModExpress($krd,$radicado)
{
            $sql="select u.usua_login, u.usua_nomb
                  from hist_eventos h
                  join usuario u on h.usua_codi=u.usua_codi and h.depe_codi=u.depe_codi
                  where radi_nume_radi=$radicado and sgd_ttr_codigo=60";
            $rs=$this->cursor->conn->Execute($sql);
            if($rs && !$rs->EOF)
            {
                if($krd==$rs->fields['USUA_LOGIN'])
                    return "1";
                else
                    return $rs->fields['USUA_NOMB'];
            }
            else return "1";
}

}


?>

