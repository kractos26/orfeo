<?php

// Nombre de la base de datos de ORFEO
$servicio = 'sgcprod';
$db = $servicio;
// Usuario de conexion con permisos de modificacion y creacion de objetos en la Base de datos.
$usuario = 'ORFEODB';
// Contrasena del usuario anterior
$contrasena = 'Temporal2';
// Nombre o IP del servidor de BD. Opcional puerto, p.e. 120.0.0.1:1521
$servidor = 'oradbsvr-scan.sgc.gov.co:1548';
// Tipo de Base de datos. Los valores validos son: postgres, oci8, mssql.
$driver = 'oci8';
// Variable que indica el ambiente de trabajo, sus valores pueden ser: desarrollo/prueba/orfeo
$ambiente = '';

// Servidor que procesa los documentos (Combinador .doc)
$servProcDocs = '';

// Acronimo de la empresa
$entidad = 'SGC';
// Nombre de la Empresa
$entidad_largo = 'Servicio Geol�gico Colombiano';
// Direccion de la Empresa.
$entidad_dir = 'Diagonal 53 No. 34 - 53';
// PBX de la Empresa.
$entidad_tel = '(571)220 0200';

$entidad_depsal = 999; //Guarda el codigo de la dependencia de salida por defecto al radicar dcto de salida.
// 0 = Carpeta salida del radicador		>0 = Redirecciona a la dependencia especificada.
//Validar si para archivar un radicado OBLIGA que esté en un expediente.
$archivado_requiere_exp = false;

$ESTILOS_PATH="orfeo38";
// Se crea la variable $ADODB_PATH. 
// El objetivo es que al independizar ADODB de ORFEO, este (ADODB) se pueda actualizar sin causar
// traumatismos en el resto del codigo de ORFEO. En adelante se utilizará esta variable para hacer
// referencia donde se encuentre ADODB

$ADODB_PATH = dirname(__FILE__) . '/include/class/adodb/';
$ADODB_CACHE_DIR = '/var/lib/php/session/';

$MODULO_RADICACION_DOCS_ANEXOS = 1;
$carpetaBodega = "poolsgc2013/";
//Notificaciones por correo
$SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
$SMTPAuth = false;  // authentication enabled
$SMTPSecure = false; // secure transfer enabled REQUIRED for GMail
$Host = '172.25.1.3';
$Port = 25;
$Username = "";
$Password = "";
$from="participacion.ciudadana@sgc.gov.co";
$from_name="Orfeo".$entidad;
//
// Configuracion LDAP
//
// Nombre o IP del servidor de autenticacion LDAP
$ldapServer = 'ldaps://macadan.ingeominas.local';
// Cadena de busqueda en el servidor.
$cadenaBusqLDAP = 'ou=usuarios,dc=ingeominas,dc=local';
// Campo seleccionado (variable LDAP) para realizar la autenticacion.
$campoBusqLDAP = 'uid';
$campoBusqLDAP = 'cn';
?>
