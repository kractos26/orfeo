<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Correo
 *
 * @author working
 */
class Correo {
    //put your code here
    function contenido($diasfaltantes,$fecha,$isPQR)
    {   
        if($isPQR):
            switch ($diasfaltantes):
                case 2:
                case 5:
                    $mensaje= "<p>Le recuerdo que el $fecha, es la fecha limite para responder la(s) PQRD N° *RAD* <p>";
                case 1:
                case 0:
                    $mensaje= "<p>Le recuderdo que hoy $fecha vence el plazo para responder la(s) PQRD N° *RAD* <p>";
                break;
                default:
                    if($diasfaltantes < 0):
                        $mensaje = "<p>Con el fin de realizar el informe de los derechos de petición,quejas reclamos y denuncias, "
                            . "amablemente solicito enviar el radicado y fechas de respuesta de las PQRD N° *RAD*, las cuales no se encuentra en el "
                            . "sistmea Orfeo </p>";
                    endif;  
                break;
            endswitch;
        endif;
        return $mensaje;
    }
    
    function footer($isPQr)
    {
        if($isPQr):
            $footer = "<p>No olvide hacer el asociado en el Sistema Orfeo, digitación de la respuesta y"
                . " el stiker de correspondencia, en caso que sea"
                . "por correo electronico anexar correo.</p>";
        endif;
        return $footer;
    }
    
    function saludo($isPQr,$nombre)
    {   
        if($isPQr):
            $saludo = "<p>Cordial saludo: Sr(a) ".$nombre."</p>";
        endif;
        return $saludo;
    }
    
    
    
}
