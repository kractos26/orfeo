e<?php 
session_start();

    $ruta_raiz = "."; 
    if (!$_SESSION['dependencia'])
        header ("Location: $ruta_raiz/cerrar_session.php");

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;


$krd         = $_SESSION["krd"];
$dependencia = $_SESSION["dependencia"];
$usua_doc    = $_SESSION["usua_doc"];
$codusuario  = $_SESSION["codusuario"];
$tip3Nombre  = $_SESSION["tip3Nombre"];
$tip3desc    = $_SESSION["tip3desc"];
$tip3img     = $_SESSION["tip3img"];

include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler($ruta_raiz);	 

$numeroa =
$numero  =
$numeros = 
$numerot =
$numerop = 
$numeroh =0;

$isql    = "select  
                 a.*
                 ,b.depe_nomb 
            from 
                 usuario a
                 ,dependencia b 
             where 
                a.depe_codi=b.depe_codi
                and a.USUA_CODI = $codusuario 
                and b.DEPE_CODI = $dependencia";
$rs=$db->query($isql);	

$dependencianomb = $rs->fields["DEPE_NOMB"];
$usua_login      = $rs->fields["USUA_LOGIN"];

?>
<html>
<head>
    <script language="JavaScript" type="text/JavaScript">
        function MM_findObj(n, d){
            var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                    if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n]; for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                if(!x && d.getElementById) x=d.getElementById(n); return x;
        }

        function MM_validateForm(){
            var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
            for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
            if (val) { nm=val.name; if ((val=val.value)!="") {
                if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
                if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
                } else if (test!='R') { num = parseFloat(val);
                if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
                if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
                min=test.substring(8,p); max=test.substring(p+1);
                if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
                } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
            } if (errors) alert('Asegurese de entrar el password Correcto, \N No puede ser Vacio:\n');
            document.MM_returnValue = (errors == '');
        }
    </script>
    <title>Cambio de Contrase&ntilde;as</title>
    <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
</head>

<body>
    <form action='usuarionuevo.php' method="post" onSubmit="MM_validateForm('contradrd','','R','contraver','','R');return document.MM_returnValue">
	    <input type='hidden' name='<?=session_name()?>' value='<?=session_id()?>'> 
	    <CENTER>
	        <table border=0 cellspacing="0" width="300px">
                <br/><br/><br/>
                <tr>
                    <td class=listado2 colspan="2">
	                    <center>Introduzca la nueva contrase&ntilde;a <b><?=$usua_login?></b>
                    </td>
                </tr>
                <tr>
	                <td class=listado2><center>Contrase&ntilde;a</td>
	                <td class=listado2><input type="password" name="contradrd" class="tex_area"></td>
	            </tr>
                <tr>
                    <td class=listado2><center>Re-escriba<br>la contrase&ntilde;a</td>
	                <td class=listado2><input type="password" name="contraver" class="tex_area"></td>
                </tr>					 
                <tr>
                    <td class=listado2 colspan="2"><center><input type="submit" value="Aceptar" class="botones"></td>
                </tr>
	        </table>
	    </CENTER>
	 </form>
</body>
</html>
