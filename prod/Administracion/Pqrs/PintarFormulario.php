<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PintarFormulario
 *
 * @author Julian Andres Ortiz Moreno
 * 3213006681
 */
 $ruta_raiz = "../..";
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	
define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;


class PintarFormulario {
    //put your code here
    var $db;
    var $lista = "";
    var $control = "";
    
   function __construct($ruta_raiz)
   {
      $this->db = new ConnectionHandler("$ruta_raiz");
   }
    
   
   function PintarControles($name,$tipo,$tabla,$option,$value,$ayuda,$obligatorio,$evento,$funcionjs,$selectdefault,$tamano,$tabindex)
   { 
       $tabindex2=$tabindex;
       $label=($obligatorio)?"<label class='astirisco' for='obligatorio'>*</label>":"&nbsp;&nbsp;";
       $clasecontroles = ($tipo != "checkbox")?"caja":"";
       $claseobligatorio = ($obligatorio == 1)?"required":"";
       $tabindex = ($tabindex > 0)?"tabindex='$tabindex'":"";
       $fun = ($evento && $funcionjs)?"".$evento."='".$funcionjs.";'":"";
       $ayuda=($ayuda)?$ayuda:"vacio";
       $tamano =($tamano)?"maxlength=".$tamano."":"";
       
       switch($tipo)
       {
           case 1:
                $tipo ="text";
               break;
           case 2:
                $tipo = "select";
               break;
           case 3:
              $tipo="checkbox";
               break;
           case 4:
                $tipo = "textarea";
                
               break;
           case 5:
                $tipo = "radio";
               break;
           case 6:
              $tipo = "hidden";
               break;
           case 7:
               $tipo = "number";
               $clasetipo="solo-numero";
               $error = "data-error='el número de identificación es numérico en caso de ser una persona juridica la identifición va entre 8000000000 a 9999999999'";

               break;
           case 9:
               $tipo = "adjunto";
               break;
           case 10:
               $tipo = "email";
               $error = "data-error='dirección de correo invalida'";

               $clasetipo="solo-correos";
               break;
           case 11:
               $tipo = "catcha";
               break;
            case 12:
               $tipo = "tel";
               break;
           
	       
               
       }
       
       if($tipo == "select")
       {
          $this->control= $this->PintarListas($name, $tabla, $value, $option,$ayuda,$obligatorio,$evento,$funcionjs,$selectdefault,$tabindex2);
       }
       elseif($tipo == "textarea")
       {
           $this->control = "<textarea name='$name' id='$name' "
                   . "class='$clasepubli form-control' title='".$ayuda."' $fun "
                   . "  placeholder='' $tabindex $claseobligatorio $tamano ></textarea>";
       }
       elseif($tipo =="adjunto")
       {
           $this->control="<div id='li_upload'>
	<div id='filelimit-fine-uploader'></div>
	<div id='availabeForUpload'></div>
	&nbsp;
	</div>";
       }
       elseif($tipo =="catcha")
       {
         $this->control= '<div  class="g-recaptcha col-sm-6" data-sitekey="6LcoORQTAAAAAHTelY43XFzWfHzWD63GZF0PaXNL"></div>
';
       }
     else
       {
           $this->control = '<input type="'.$tipo.'" name="'.$name.'" id="'.$name.'" class="form-control '.$clasecontroles.' "   '.$error.'  '
                   . 'title="'.$ayuda.'" '.$tamano.' '.$tabindex.'  value="'.$value.'" '.$fun.' '.$claseobligatorio.' />'
                   . '<div class="help-block with-errors" title="error" >'
                   . '</div>';
       }
       
       return $this->control;
   }
   
   function PintarListas($name, $tabla, $value, $option,$ayuda,$obligatorio,$evento,$funcionjs,$selectdefault,$tabindex){
       
        $tabindex = ($tabindex > 0)?"tabindex='$tabindex'":"";
        $clasepubli = ($publico)?"publico":"";
         $fun = ($evento && $funcionjs)?"".$evento."='".$funcionjs.";'":"";
        $claseobligatorio = ($obligatorio == 1)?"required":"";
        $sql = "SELECT $option as OPCION,$value as NOMBRE FROM $tabla order by NOMBRE ASC";
       
   
        $resultado = $this->db->conn->Execute($sql);
        $lista= $resultado->GetMenu3( $name,$selectdefault,true, false, 0,'   title="'.$ayuda.'" class="form-control" id="'.$name.'" '.$fun.' '.$claseobligatorio.'  '.$tabindex.'' );
        $this->lista = $lista;
        return $this->lista.$label;
    }
    
    function ActualizarRegistros($tabla,$arreglo,$arreglowhere)
        {
        $this->db->update($tabla, $arreglo,$arreglowhere);
    }
    
    function ModificarControles($arreglo)
    {
        $datos = $arreglo;
        
    }
    
    function aclaracionModulo($var)
    {
        switch ($var)
        {
            case 1:
                echo "Secion de datos generales";
                break;
            case 2:
                echo "En la secion de datos personales se pide que por favor ingrese datos como direccion,municipio etc..";
                break;
            case 3:
                echo "En esta secion se requiere espesificar información para poder contactarlo...";
                break;
            
            case 4:
                echo "El catcha es requerido con motivos de comprovar si usted no es una maquina";
            break;
        }
    }
    
    
    
}
?>
