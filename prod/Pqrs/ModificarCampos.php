<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.

 * 
 * 
 */

for($i=0;$i<count($datos);$i++)
            {
                
                 if(isset($_POST['desplegable_'.$datos[$i]]))
                 {
                    $arreglodatos['TIPOCAMPO'] = "'".trim($_POST['desplegable_'.$datos[$i]])."'";      
                }
                if(isset($_POST['oculto_'.$i]))
                {
                  $arreglodatos['TIPOCAMPO'] = "'".trim($_POST['oculto_'.$datos[$i]])."'"; 

                }
                if($_POST['tipocampo_'.$datos[$i]] !=0)
                {
                     $arreglodatos['TIPOCAMPO'] = "'".trim($_POST['tipocampo_'.$datos[$i]])."'";

                }
                
                $contenido = htmlentities($_POST['etiqueta_'.$datos[$i]]);
                
                $arreglodatos['ETIQUETA']="'".$contenido."'";
                $arreglodatos['ACTIVO'] =  "'".$_POST['activo_'.$datos[$i]]."'";
                $arreglodatos['PUBLICO'] = "'".$_POST['publico_'.$datos[$i]]."'";
                $arreglodatos['OBLIGATORIO'] = "'".$_POST['obligatorio_'.$datos[$i]]."'";
                $arreglodatos['AYUDA'] = "'".trim(utf8_decode($_POST['ayuda_'.$datos[$i]]))."'";
                $arreglodatos['TABLA'] = "'".trim($_POST['tabla_'.$datos[$i]])."'";
                $arreglodatos['VALUE'] = "'".trim($_POST['value_'.$datos[$i]])."'";
                $arreglodatos['OPCION'] = "'".trim($_POST['option_'.$datos[$i]])."'";
                $arreglodatos['TAMANO'] = "'".trim($_POST['tamano_'.$datos[$i]])."'";
                $db->update("FORMULARIOCAMPOPQR", $arreglodatos, 
                       array('IDFORMULARIO'=>"'".$_POST['formulario']."'", 'IDCAMPO' => $datos[$i]));
            }


?>

