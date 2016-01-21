<?php
error_reporting(0);

function checkldapuser($username,$password)
{   require('config.php');
    $username=strtolower($username);
    $connect = ldap_connect($ldapServer);
    if($connect != false)
    {
        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
        // enlace a la conexiÃ³n
        $bind = ldap_bind($connect,$usrLDAP,$pwdLDAP);
        if($bind == false)
        {   $mensajeError =  "Falla la conexi&oacute;n con el servidor LDAP con el usuario 
$usrLDAP";
            return $mensajeError;
        }
	// active directory - pch
	$bind = (@ldap_bind($connect, "$campoBusqLDAP=".$username.",$cadenaBusqLDAP", $password));
	if($bind == false)
	{
		$mensajeError = "Usuario o contraseña incorrecta";
		return $mensajeError;
	}

	// busca el usuario - pch
	if (($res_id = ldap_search( $connect, $cadenaBusqLDAP, "$campoBusqLDAP=".$username)) == false)
	{
		$mensajeError = "No encontrado el usuario en el LDAP";
		return $mensajeError;
	}


       $cant = ldap_count_entries($connect, $res_id);
       if ($cant == 0)
       {
           $mensajeError =  "El usuario $username NO se encuentra en el A.D. $bind HLPHLP";
           return $mensajeError;
       }

       if ($cant > 1)
       {
           $mensajeError =  "El usuario $username se encuentra $cant veces en el A.D.";
           return $mensajeError;
       }

       $entry_id = ldap_first_entry($connect, $res_id);
       if ($entry_id == false)
       {
           $mensajeError =  "No se obtuvieron resultados";
           return $mensajeError;
       }

       if (( $user_dn = ldap_get_dn($connect, $entry_id)) == false) {
            $mensajeError = "No se puede obtener el dn del usuario";
         return $mensajeError;
       }
        error_reporting( 0 );
       /* Autentica el usuario */
       if (($link_id = ldap_bind($connect, "$user_dn", $password)) == false) {
        error_reporting( 0 );
        $mensajeError = "USUARIO O CONTRASE&Ntilde;A INCORRECTOS";
         return $mensajeError;
       }

       return '';
       @ldap_close($connect);
  }
  else {
   $mensajeError = "no hay conexi&oacute;n a '$ldap_server'";
   return $mensajeError;
  }

  @ldap_close($connect);
  return(false);

}

?>
