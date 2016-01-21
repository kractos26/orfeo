<?php


// Ruta del directorio que contiene el enlace a la $carpetaBodega de imágenes

$ruta_raiz = "..";
$anoCrear = date("Y");
//error_reporting(7);

include_once ( "$ruta_raiz/include/db/ConnectionHandler.php" );
include_once("$ruta_raiz/config.php");
if(!$carpetaBodega)$carpetaBodega="bodega/";



// Verifica si existe un directorio cuyo nombre corresponde al año actual

if ( is_dir( $ruta_raiz."/$carpetaBodega"."".$anoCrear ) )

{

    // Función para crear los directorios asociados a cada dependencia

    creaDirDepe( $ruta_raiz,$carpetaBodega);

}

// Si no existe un directorio cuyo nombre corresponde al año actual lo crea

else

{

    // Crea un directorio cuyo nombre corresponde al año actual

    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."".$anoCrear, 0777 ) )

    {

        print "Directorio ".$ruta_raiz."/$carpetaBodega"."".$anoCrear." creado.<br>";



        // Función para crear los directorios asociados a cada dependencia

        creaDirDepe( $ruta_raiz, $carpetaBodega);

    }

    else

    {

        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."".$anoCrear."<br>";

    }

}



// Directorio fax

// Verifica si no existe el directorio fax

if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."fax" ) )

{

    // Crea un directorio llamado fax

    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."fax", 0777 ) )

    {

        print "Directorio ".$ruta_raiz."/$carpetaBodega"."fax"." creado.<br>";

    }

    else

    {

        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."fax.<br>";

    }

}



// Directorio masiva

// Verifica si no existe el directorio masiva

if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."masiva" ) )

{

    // Crea un directorio llamado masiva

    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."masiva", 0777 ) )

    {

        print "Directorio ".$ruta_raiz."/$carpetaBodega"."masiva"." creado.<br>";

    }

    else

    {

        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."masiva.<br>";

    }

}



// Directorio pdfs

// Verifica si no existe un directorio pdfs

if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."pdfs" ) )

{

    // Crea un directorio llamado pdfs

    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."pdfs", 0777 ) )

    {

        print "Directorio ".$ruta_raiz."/$carpetaBodega"."pdfs"." creado.<br>";



        // Directorio guias

        // Verifica si no existe un directorio guias

        if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."pdfs/guias" ) )

        {

            // Crea un directorio llamado guias

            if ( mkdir ( $ruta_raiz."/$carpetaBodega"."pdfs/guias", 0777 ) )

            {

                print "Directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/guias"." creado.<br>";

            }

            else

            {

                print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/guias.<br>";

            }

        }



        // Directorio planillas

        // Verifica si no existe un directorio planillas

        if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."pdfs/planillas" ) )

        {

            // Crea un directorio llamado planillas

            if ( mkdir ( $ruta_raiz."/$carpetaBodega"."pdfs/planillas", 0777 ) )

            {

                print "Directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/planillas"." creado.<br>";



                // Directorio dev

                // Verifica si no existe un directorio dev

                if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."pdfs/planillas/dev" ) )

                {

                    // Crea un directorio llamado dev

                    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."pdfs/planillas/dev", 0777 ) )

                    {

                        print "Directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/planillas/dev"." creado.<br>";

                    }

                    else

                    {

                        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/planillas/dev.<br>";

                    }

                }



                // Directorio envios

                // Verifica si no existe un directorio envios

                if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."pdfs/planillas/envios" ) )

                {

                    // Crea un directorio llamado envios

                    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."pdfs/planillas/envios", 0777 ) )

                    {

                        print "Directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/planillas/envios"." creado.<br>";

                    }

                    else

                    {

                        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/planillas/envios.<br>";

                    }

                }

            }

            else

            {

                print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."pdfs/planillas.<br>";

            }

        }

    }

    else

    {

        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."pdfs.<br>";

    }

}



// Directorio tmp

// Verifica si no existe un directorio tmp

if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."tmp" ) )

{

    // Crea un directorio llamado tmp

    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."tmp/workDir/cacheODT", 0777,true ) )

    {

        print "Directorio ".$ruta_raiz."/$carpetaBodega"."tmp/workDir/cacheODT"." creado.<br>";

    }

    else

    {

        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."tmp/workDir/cacheODT.<br>";

    }

}

if ( ! is_dir( $ruta_raiz."$carpetaBodega/Ayuda/" ) )

{
    // Crea un directorio llamado plantillas

    if ( mkdir ( $ruta_raiz."/$carpetaBodega/Ayuda/", 0777,true ) )

    {

        print "Directorio ".$ruta_raiz."/$carpetaBodega/Ayuda/"." creado.<br>";

    }

    else

    {

        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega/Ayuda/.<br>";

    }

}



// Función para crear los directorios asociados a cada dependencia

function creaDirDepe( $ruta_raiz,$carpetaBodega )

{

    $db = new ConnectionHandler( "$ruta_raiz" );

    //$db->conn->debug = true;



    $query  = "SELECT DEPE_CODI";
    $query .= " FROM dependencia";

    // print "query: ".$query;

    $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
    $rs = $db->query($query);
    while( !$rs->EOF )
    {
	  $anoCrear= date("Y");
        // Verifica si existe un directorio cuyo nombre corresponde al código de la

        // dependencia

        if ( is_dir( $ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT) ) )

        {

            // Directorio docs

            // Verifica si no existe un directorio docs

            //if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."".$anoCrear."/".$rs->fields["DEPE_CODI"]."/" ) )

            //{
                // Crea un directorio llamado docs
                if ( mkdir ( $ruta_raiz."/$carpetaBodega".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."/docs", 0777 ) )
                {
                    print "Directorio ".$ruta_raiz."/$carpetaBodega".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."/docs"." creado.<br>";
                }
                else
                {
                    print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."/docs.<br>";
                }

            }

        //}

        // Si no existe un directorio cuyo nombre corresponde al código de la dependencia,

        // lo crea

        else

        {

            // Crea un directorio cuyo nombre corresponde al código de la dependencia

            if ( mkdir ( $ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT), 0777 ) )

            {

                print "Directorio ".$ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)." creado.<br>";



                // Directorio docs

                // Verifica si no existe un directorio docs

                if ( ! is_dir( $ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."/docs" ) )

                {

                    // Crea un directorio llamado docs

                    if ( mkdir ( $ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."/docs", 0777 ) )

                    {

                        print "Directorio ".$ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."/docs"." creado.<br>";

                    }

                    else

                    {

                        print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."/docs.<br>";

                    }

                }

            }

            else

            {

                print "No se pudo crear el directorio ".$ruta_raiz."/$carpetaBodega"."".$anoCrear."/".str_pad($rs->fields["DEPE_CODI"],3,"0", STR_PAD_LEFT)."<br>";

            }

        }

        $rs->MoveNext();

    }

}

?>
