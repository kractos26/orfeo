<?
/**
 * CONSULTA VERIFICACION PREVIA A LA RADICACION
*/
$sqlConcatC = $tmp_hlp;
$condicion  = $tmp_hlp;
switch($db->driver)
{
	case 'mssql':
	{
		$nombre = "convert(char(14),a.radi_nume_sal)";
		$nombre2 = $db->conn->Concat("convert(char(14),radi_nume_sal,0)","'-'","cast(sgd_renv_codigo as varchar)");
                $nombre3 = $db->conn->Concat("convert(char(14),radi_nume_sal,0)","'-'","cast(dir.sgd_dir_tipo as varchar)");
                $dir="convert(char(14),dir.sgd_dir_tipo )";
	}break;
	case 'oracle':
	case 'oci8':
	case 'oci805':
        case 'oci8po':
        default:
	{
		$nombre = "(a.radi_nume_sal)";
		$nombre2 = $db->conn->Concat("radi_nume_sal","'-'","sgd_renv_codigo");
                $nombre3 = $db->conn->Concat("radi_nume_sal","'-'","dir.sgd_dir_tipo");
                $dir="dir.sgd_dir_tipo";
	}break;
	case 'postgres':
	{
		$nombre = "(a.radi_nume_sal)";
		$nombre2 = $db->conn->Concat("cast(radi_nume_sal as varchar)","'-'","cast(sgd_renv_codigo as varchar)");
                $nombre3 = $db->conn->Concat("cast(radi_nume_sal as varchar)","'-'","cast(dir.sgd_dir_tipo as varchar)");
                $dir="cast(dir.sgd_dir_tipo as varchar)";
	}break;
	default:
	{
		$nombre = "(a.radi_nume_sal)";
		$nombre2 = $db->conn->Concat("radi_nume_sal","'-'","sgd_renv_codigo");
                $nombre3 = $db->conn->Concat("radi_nume_sal","'-'","dir.sgd_dir_tipo");
	}break;
}
?>
