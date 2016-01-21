<?php
switch ($driver) { 
	case 'oci8':
        case 'oci8po':
	case 'oracle':
	case 'mssql':
	case 'postgres':
		$query1="select a.SGD_DIR_CODIGO,a.SGD_DIR_DIRECCION,a.SGD_DIR_TELEFONO,a.SGD_DIR_MAIL,b.SGD_CIU_NOMBRE AS NOMBRE,b.SGD_CIU_APELL1 AS APELL1,b.SGD_CIU_APELL2 AS APELL2,b.SGD_CIU_CEDULA,a.SGD_DIR_TIPO,a.SGD_ESP_CODI,a.SGD_OEM_CODIGO,a.SGD_CIU_CODIGO,a.SGD_DOC_FUN,a.SGD_DIR_NOMBRE,a.SGD_ANEX_CODIGO
	         from sgd_dir_drecciones a
	         LEFT OUTER JOIN  sgd_ciu_ciudadano b ON   a.sgd_ciu_codigo = b.sgd_ciu_codigo
	         where
	         a.sgd_anex_codigo='$codigo' and
			   a.sgd_dir_tipo > 700 and a.sgd_dir_tipo !=7";
	break;
	}

?>
