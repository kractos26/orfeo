<?php
/*
 * Archivo auxiliar para la administracion de repositorios de ciudadanos y entidades
 * @autor Ing.John Guerrero
 */

session_start();
$ruta_raiz = "../..";
//if($_SESSION['usua_admin_sistema'] !=1 ) die(include "$ruta_raiz/errorAcceso.php");

if (!isset($krd))
    $krd = $_POST['krd']; else
    $krd = $_GET['krd'];
 
$ruta_raiz = "../..";
if (!isset($_SESSION['dependencia']))
    include "$ruta_raiz/rec_session.php";
define('ADODB_ASSOC_CASE', 1);
require_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler($ruta_raiz);
$error = 0;
     $a=spliti("-",$_POST['codmuni'],3);
            $b=spliti("-",$_POST['coddep'],2);
if ($db) {
    $CiuWhere = " where sgd_ciu_codigo=" . $_POST['ciudadano'];
    $EntWhere = " where sgd_oem_codigo=" . $_POST['entidad'];
    $sqlCiu = "SELECT   sgd_ciu_nombre nombre, 
                        sgd_ciu_codigo codigo,
                        sgd_ciu_direccion direccion, 
                        sgd_ciu_apell1 apell1, 
                        sgd_ciu_apell2 apell2, 
                        sgd_ciu_telefono  telefono,
                        sgd_ciu_email mail,
                        sgd_ciu_cedula doc,
                        sgd_ciu_act act,
                        muni_codi,
                        dpto_codi,
                        id_cont,
                        id_pais
                        FROM sgd_ciu_ciudadano $CiuWhere
                        ORDER BY sgd_ciu_nombre ";

    $sqlEnt = "SELECT   sgd_oem_oempresa nombre,
                        sgd_oem_codigo codigo,
                        sgd_oem_nit NIT,
                        sgd_oem_rep_legal repre,
                        sgd_oem_telefono telefono,
                        sgd_oem_sigla sig,
                        sgd_oem_direccion direccion,
                        sgd_oem_act act,
                        muni_codi,
                        dpto_codi,
                        id_cont,
                        id_pais
                        FROM sgd_oem_oempresas $EntWhere
                        ORDER BY sgd_oem_oempresa ";
    /*
     *     $.post("CiuEntAux.php",{
      ModType:$('select[name="ModType"]').val()
      ,
      ciudadano:$("#sl_ciu").val()
      ,
      entidad:$("#sl_ent").val()
      },function(result){
      $("#SearchResult").empty().html(result);
      });
     */
    if(empty($_POST['bandera'])){
        
        if (isset($_POST['ModType']) && !$_POST['Act']) {
        if ($_POST['ModType'] == 1) {
            $RsCiu = $db->conn->Execute($sqlCiu);
            ?>
            <script type="text/javascript">
              
              $("#txt_id").val('<?= $RsCiu->fields['DOC'] ?>');
              $("#Codi").val('<?= $RsCiu->fields['CODIGO'] ?>');
              $("#txt_apell1").val('<?= $RsCiu->fields['APELL1'] ?>');
               $("#txt_apell2").val('<?= $RsCiu->fields['APELL2'] ?>');
            $("#txt_mail").val('<?= $RsCiu->fields['MAIL'] ?>');
              $("#txt_tel").val('<?= $RsCiu->fields['TELEFONO'] ?>');
                $("#txt_dir").val('<?= $RsCiu->fields['DIRECCION'] ?>');
              $("#idcont1").val('<?= $RsCiu->fields['ID_CONT'] ?>');
              $("#txt_name").val('<?= $RsCiu->fields['NOMBRE'] ?>');
              
            <? if ($RsCiu->fields['ACT'] == '1') { ?>
                    $("#Slc_act").val('S');
            <? } else { ?>
                    $("#Slc_act").val('N');
            <? } ?>
                crea_var_idlugar_defa('<?= $RsCiu->fields['ID_CONT'] ?>'+'-'+'<?= $RsCiu->fields['ID_PAIS'] ?>'+'-'+'<?= $RsCiu->fields['DPTO_CODI'] ?>'+'-'+'<?= $RsCiu->fields['MUNI_CODI'] ?>');
                                                                                                                                                                
                                                                                                                                                                                
            </script>
            <?
        } else {
            $RsEnt = $db->conn->Execute($sqlEnt);
            ?>
            <!--             <script language="JavaScript" src="<?= $ruta_raiz ?>/js/crea_combos_2.js"></script>-->
            <script type="text/javascript">
                $("#txt_name").val('<?= $RsEnt->fields['NOMBRE'] ?>');
                $("#txt_id").val('<?= $RsEnt->fields['NIT'] ?>');
                $("#Codi").val('<?= $RsEnt->fields['CODIGO'] ?>');
                $("#txt_rep").val('<?= $RsEnt->fields['REPRE'] ?>');
                $("#txt_sig").val('<?= $RsEnt->fields['SIG'] ?>');
                $("#txt_tel").val('<?= $RsEnt->fields['TELEFONO'] ?>');
                $("#txt_dir").val('<?= $RsEnt->fields['DIRECCION'] ?>');
            <? if ($RsEnt->fields['ACT'] == '1') { ?>
                    $("#Slc_act").val('S');
            <? } else { ?>
                    $("#Slc_act").val('N');
            <? } ?>
                crea_var_idlugar_defa('<?= $RsEnt->fields['ID_CONT'] ?>'+'-'+'<?= $RsEnt->fields['ID_PAIS'] ?>'+'-'+'<?= $RsEnt->fields['DPTO_CODI'] ?>'+'-'+'<?= $RsEnt->fields['MUNI_CODI'] ?>');
                                                                                                                                 
                                                                                                                                                                                
            </script>
            <?
        }
    } 
    }
    
    else if($_POST['bandera']==1 || $_POST['bandera']==2 || $_POST['bandera']==3 ) {
        if ($_POST['Act'] == 'S') {
            $value = '1';
        } else {
            $value = '0';
        }
        if ($_POST['ModType'] == 1) {
                     
              if($_POST['bandera']==3){
                 
               $rsql=" select COUNT(RADI_NUME_RADI) as regis from sgd_dir_drecciones where SGD_CIU_CODIGO ='".$_POST['ciudadano']."' order by RADI_NUME_RADI";
              
               $ry = $db->conn->Execute($rsql);
           
               if($ry->fields['REGIS'] > 0)
                   {  
                        echo '<script type="text/javascript">alert("No se puede eliminar el registro, se encuentra asociado a radicado en Orfeo.");window.location.reload();</script>';
                   }
                   else{
                       $del = "DELETE  FROM SGD_CIU_CIUDADANO $CiuWhere";
                       $db->conn->Execute($del);
                       {  echo '<script type="text/javascript">alert("Se elimin\u00f3 satisfactoriamente");window.location.reload();</script>';

                          }
             }
              }
        else if($_POST['bandera']==2)
         {
      
           
            $SQL = " UPDATE SGD_CIU_CIUDADANO SET SGD_CIU_ACT = $value ,SGD_CIU_NOMBRE='".strtoupper($_POST['nombre'])."',SGD_CIU_DIRECCION='".$_POST['dir']."',SGD_CIU_APELL1='".$_POST['primerape']."',SGD_CIU_APELL2='".$_POST['segundoape']."',SGD_CIU_TELEFONO='".$_POST['tel']."',SGD_CIU_EMAIL='".$_POST['correo']."',MUNI_CODI='".$a[2]."',DPTO_CODI='".$b[1]."',SGD_CIU_CEDULA='".$_POST['cc']."',ID_CONT='".$_POST['codconti']."',ID_PAIS='".$_POST['codciu']."' $CiuWhere";
          
            $Rs = $db->conn->Execute($SQL);
            if ($Rs) {
                echo '<script type="text/javascript">alert("Se actualiz\u00f3 el registro satisfactoriamente");window.location.reload();</script>';
            } else {
                echo '<script type="text/javascript">alert("Falla al actualizar el registro ");</script>';
            }
            
           }
           
           else if($_POST['bandera']==1)
            {       	$nextval=$db->nextId("sec_ciu_ciudadano");
                  $SQL="INSERT INTO SGD_CIU_CIUDADANO(TDID_CODI,SGD_CIU_CODIGO,SGD_CIU_ACT,
                      SGD_CIU_NOMBRE,SGD_CIU_DIRECCION,SGD_CIU_APELL1,SGD_CIU_APELL2,
                      SGD_CIU_TELEFONO,SGD_CIU_EMAIL,MUNI_CODI,DPTO_CODI,SGD_CIU_CEDULA,ID_CONT,ID_PAIS)
                      VALUES(2,$nextval,$value,'".strtoupper($_POST['nombre'])."','".$_POST['dir']."','".strtoupper($_POST['primerape'])."',
                          '".strtoupper($_POST['segundoape'])."','".$_POST['tel']."','".$_POST['correo']."','".$a[2]."','".$b[1]."',
                              '".$_POST['cc']."','".$_POST['codconti']."','".$_POST['codciu']."')";
                  $Rs = $db->conn->Execute($SQL);
                
                      if ($Rs) {
                echo '<script type="text/javascript">alert("Se agreg\u00f3 el registro satisfactoriamente");window.location.reload();</script>';
                      } else {
                echo '<script type="text/javascript">alert("Falla al insertar el registro ");</script>';
                         }
            }
           
               
               
        } 
        
      else {
           if($_POST['bandera']==3){
                      $rsql=" select COUNT(RADI_NUME_RADI) as regis from sgd_dir_drecciones where SGD_OEM_CODIGO ='".$_POST['entidad']."' order by RADI_NUME_RADI";
                            
               $ry = $db->conn->Execute($rsql);
               if($ry->fields['REGIS'] > 0)
                   {  echo '<script type="text/javascript">alert("No se puede eliminar el registro, se encuentra asociado a radicado en Orfeo. ");window.location.reload();</script>';
                   }
                   else{
                       $del = "DELETE  FROM SGD_OEM_OEMPRESAS  $EntWhere";
                       $db->conn->Execute($del);
                       {  echo '<script type="text/javascript">alert("Se elimin\u00f3 satisfactoriamente");window.location.reload();</script>';

                   }
             }

           }
           if($_POST['bandera']==2)
         {
            
            $isql = "UPDATE SGD_OEM_OEMPRESAS SET SGD_OEM_NIT='".$_POST['nit']."', SGD_OEM_OEMPRESA='".strtoupper(strtoupper(str_ireplace("'","''",$_POST['nombre'])))."',
				SGD_OEM_DIRECCION='".str_ireplace("'","''",$_POST['dir'])."', SGD_OEM_REP_LEGAL='".str_ireplace("'","''",$_POST['repre'])."', SGD_OEM_SIGLA='".str_ireplace("'","''",$_POST['sigla'])."',
				SGD_OEM_TELEFONO='".$_POST['tel']."', ID_CONT='".$_POST['codconti']."', ID_PAIS='".$_POST['codciu']."', DPTO_CODI=$b[1], 
				MUNI_CODI=$a[2],SGD_OEM_ACT='".$value."'  $EntWhere";
     
            $Rs = $db->conn->Execute($isql);
            if ($Rs) {
                                echo '<script type="text/javascript">alert("Se actualiz\u00f3 el registro satisfactoriamente");window.location.reload();</script>';

            } else {
                echo '<script type="text/javascript">alert("Falla al actualizar el registro ");</script>';
            }
         }
           else if($_POST['bandera']==1)
            {  $nextval=$db->nextId("sec_oem_oempresas");
            $isql = "INSERT INTO SGD_OEM_OEMPRESAS(tdid_codi,SGD_OEM_ACT, SGD_OEM_CODIGO, SGD_OEM_NIT, SGD_OEM_OEMPRESA, SGD_OEM_DIRECCION, 
				SGD_OEM_REP_LEGAL, SGD_OEM_SIGLA, SGD_OEM_TELEFONO, ID_CONT, ID_PAIS, DPTO_CODI, MUNI_CODI) 
				values (4,$value ,$nextval, '".$_POST['nit']."', '".strtoupper(str_ireplace("'","''",$_POST['nombre']))."', '".str_ireplace("'","''",$_POST['dir'])."', '".str_ireplace("'","''",$_POST['repre'])."',
						'".str_ireplace("'","''",$_POST['sigla'])."', '".$_POST['tel']."','".$_POST['codconti']."', '".$_POST['codciu']."', $b[1], $a[2])";
            
            $Rs = $db->conn->Execute($isql);
                
                      if ($Rs) {
                echo '<script type="text/javascript">alert("Se agreg\u00f3 el registro satisfactoriamente");window.location.reload();</script>';
                      } else {
                echo '<script type="text/javascript">alert("Falla al insertar el registro ");</script>';
                         }
            
            
        }
       
    }
} 


    }
 else {
    echo "<script type='text/javascript'>alert(\"Error de conexion a base de datos\");</script>";
}
          
?>
