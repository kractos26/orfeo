<?PHP
/**
 * Clase donde gestionamos informacion referente a los tipos de archivo.
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Desarrollado por Grupo Iyunxi Ltda.
 */
class Mime
{
private $cnn;	//Conexion a la BD.
private $flag;	//Bandera para usos varios.
private $vector;//Vector con los datos.

/**
 * Constructor de la classe.
 *
 * @param ConnectionHandler $db
 */
function __construct($db)
{
	$this->cnn = $db;
	$this->cnn->SetFetchMode(ADODB_FETCH_ASSOC);
}

/**
 * Agrega un nuevo tipo de archivo.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetInsDatos($datos)
{
	return $this->flag;
}

/**
 * Modifica datos a un tipo de archivo.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error
 *
 * No se debir�a modificar el c�digo ANEX_TIPO_CODI, validar esto en el cliente.
 */
function SetModDatos($datos)
{
	return $this->flag;
}

/**
 * Elimina un tipo de archivo.
 *
 * @param  int $dato  Id del tipo de archivo a eliminar.
 * @return boolean $flag False on Error /
 */
function SetDelDatos($dato)
{
	$sql = "SELECT COUNT(*) FROM ANEXOS WHERE ANEX_TIPO =".$dato;
	if ($this->cnn->GetOne($sql) > 0)
	{
		$this->flag = 0;
	}
	else
	{
		$this->cnn->BeginTrans();
		$ok = $this->cnn->Execute("DELETE FROM ANEXOS_TIPO WHERE ANEX_TIPO_CODI=".$dato);
		if($ok)
		{
			$this->cnn->CommitTrans();
			$this->flag = true;
		}
		else
		{
			$this->cnn->RollbackTrans() ;
			$this->flag = false;
		}
	}
	return $this->flag;
}

/**
 * Retorna un combo con las opciones de la tabla Anexos_tipo.
 *
 * @param  boolean Habilita/Deshabilita la 1a opcion SELECCIONE.
 * @param  boolean Habilita/Deshabilita la validacion Onchange hacia una funcion llamada Actual().
 * @return string Cadena con el combo - False on Error.
 */
function Get_ComboOpc($dato1, $dato2)
{
	$sql = "SELECT ANEX_TIPO_DESC AS DESCRIP, ANEX_TIPO_CODI AS ID FROM ANEXOS_TIPO ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->flag = false;
	else
	{
		($dato1) ? $tmp1="0:&lt;&lt;SELECCIONE&gt;&gt;": $tmp1 = false;
		($dato2) ? $tmp2="Onchange='Actual()'": $tmp2 = "";
		$this->flag = $rs->GetMenu("slc_cmb2",false,$tmp1,false,false,"id='slc_cmb2' class='select' $tmp2");
		unset($rs); unset($tmp1); unset($tmp2);
	}
	return $this->flag;
}

/**
 * Retorna un vector.
 *
 * @return Array Vector numérico con los datos - False on error.
 */
function Get_ArrayDatos()
{
	$sql = "SELECT ANEX_TIPO_DESC AS DESCRIP, ANEX_TIPO_CODI AS ID, ANEX_TIPO_EXT AS EXTE FROM ANEXOS_TIPO ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->vector = false;
	else
	{	$it = 1;
		while (!$rs->EOF)
		{	$vdptosv[$it]["ID"] = $rs->fields["ID"];
			$vdptosv[$it]["NOMBRE"] = $rs->fields["DESCRIP"];
			$vdptosv[$it]["USUARIO"] = $rs->fields["EXTE"];
			$it += 1;
			$rs->MoveNext();
		}
		$rs->Close();
		$this->vector = $vdptosv;
		unset($rs); unset($sql);
	}
	return $this->vector;
}
function tipoMime($file)
{
    $ext=substr($file, strripos($file, ".")+1);
    switch($ext)
    {
        case "js":  $tipo= "application/x-javascript"; break;
        case "json":  $tipo= "application/json";break;
        case "jpg":
        case "jpeg":
        case "jpe":  $tipo= "image/jpg";break;
        case "css": $tipo= "text/css";break;
        case "xml": $tipo= "application/xml";break;
        case "doc":
        case "docx": $tipo= "application/msword";break;
        case "pot":
        case "ppa":
        case "ppt":
        case "pps": $tipo= "application/vnd.ms-powerpoint";break;
        case "rtf":$tipo= "application/rtf";break;
        case "pdf":$tipo= "application/pdf";break;
        case "html":
        case "htm":
        case "php":$tipo= "text/html";break;
        case "txt": $tipo= "text/plain";break;
        case "mpeg":
        case "mpg":
        case "mpe":$tipo= "video/mpeg";break;
        case "mp3":$tipo= "audio/mp3";break;
        case "wav":$tipo= "audio/wav";break;
        case "aiff":
        case "aif":$tipo= "audio/aiff";break;
        case "avi":$tipo= "video/msvideo";break;
        case "wmv":$tipo= "video/x-ms-wmv";break;
        case "mov":$tipo= "video/quicktime";break;
        case "zip":$tipo= "application/zip";break;
        case "tar":$tipo= "application/x-tar";break;
        case "swf":$tipo= "application/x-shockwave-flash";break;
        case "odt": $tipo="application/vnd.oasis.opendocument.text";break;
        case "ods":$tipo="application/vnd.oasis.opendocument.spreadsheet";break;
        case "dwg":  $tipo="application/acad"; break;
        case "arj":  $tipo="application/arj"; break;
        case "mm":  $tipo="application/base64"; break;
        case "mme":  $tipo="application/base64"; break;
        case "hqx":  $tipo="application/binhex"; break;
        case "hqx":  $tipo="application/binhex4"; break;
        case "boo":  $tipo="application/book"; break;
        case "book":  $tipo="application/book"; break;
        case "cdf":  $tipo="application/cdf"; break;
        case "ccad":  $tipo="application/clariscad"; break;
        case "dp":  $tipo="application/commonground"; break;
        case "drw":  $tipo="application/drafting"; break;
        case "tsp":  $tipo="application/dsptype"; break;
        case "dxf":  $tipo="application/dxf"; break;
        case "evy":  $tipo="application/envoy"; break;
        case "xl":  $tipo="application/excel"; break;
        case "xla":  $tipo="application/excel"; break;
        case "xlb":  $tipo="application/excel"; break;
        case "xlc":  $tipo="application/excel"; break;
        case "xld":  $tipo="application/excel"; break;
        case "xlk":  $tipo="application/excel"; break;
        case "xll":  $tipo="application/excel"; break;
        case "xlm":  $tipo="application/excel"; break;
        case "xls":  $tipo="application/excel"; break;
        case "xlt":  $tipo="application/excel"; break;
        case "xlv":  $tipo="application/excel"; break;
        case "xlw":  $tipo="application/excel"; break;
        case "fif":  $tipo="application/fractals"; break;
        case "frl":  $tipo="application/freeloader"; break;
        case "spl":  $tipo="application/futuresplash"; break;
        case "tgz":  $tipo="application/gnutar"; break;
        case "vew":  $tipo="application/groupwise"; break;
        case "hlp":  $tipo="application/hlp"; break;
        case "hta":  $tipo="application/hta"; break;
        case "unv":  $tipo="application/i-deas"; break;
        case "iges":  $tipo="application/iges"; break;
        case "igs":  $tipo="application/iges"; break;
        case "inf":  $tipo="application/inf"; break;
        case "clas":  $tipo="application/java"; break;
        case "clas":  $tipo="application/java-byte-code"; break;
        case "lha":  $tipo="application/lha"; break;
        case "lzx":  $tipo="application/lzx"; break;
        case "bin":  $tipo="application/mac-binary"; break;
        case "hqx":  $tipo="application/mac-binhex"; break;
        case "hqx":  $tipo="application/mac-binhex40"; break;
        case "cpt":  $tipo="application/mac-compactpro"; break;
        case "bin":  $tipo="application/macbinary"; break;
        case "mrc":  $tipo="application/marc"; break;
        case "mbd":  $tipo="application/mbedlet"; break;
        case "mcd":  $tipo="application/mcad"; break;
        case "aps":  $tipo="application/mime"; break;
        case "pot":  $tipo="application/mspowerpoint"; break;
        case "ppz":  $tipo="application/mspowerpoint"; break;
        case "dot":  $tipo="application/msword"; break;
        case "w6w":  $tipo="application/msword"; break;
        case "wiz":  $tipo="application/msword"; break;
        case "word":  $tipo="application/msword"; break;
        case "wri":  $tipo="application/mswrite"; break;
        case "mcp":  $tipo="application/netmc"; break;
        case "a":  $tipo="application/octet-stream"; break;
        case "arc":  $tipo="application/octet-stream"; break;
        case "arj":  $tipo="application/octet-stream"; break;
        case "bin":  $tipo="application/octet-stream"; break;
        case "com":  $tipo="application/octet-stream"; break;
        case "dump":  $tipo="application/octet-stream"; break;
        case "exe":  $tipo="application/octet-stream"; break;
        case "lha":  $tipo="application/octet-stream"; break;
        case "lhx":  $tipo="application/octet-stream"; break;
        case "lzh":  $tipo="application/octet-stream"; break;
        case "lzx":  $tipo="application/octet-stream"; break;
        case "o":  $tipo="application/octet-stream"; break;
        case "psd":  $tipo="application/octet-stream"; break;
        case "save":  $tipo="application/octet-stream"; break;
        case "uu":  $tipo="application/octet-stream"; break;
        case "zoo":  $tipo="application/octet-stream"; break;
        case "oda":  $tipo="application/oda"; break;
        case "p12":  $tipo="application/pkcs-12"; break;
        case "crl":  $tipo="application/pkcs-crl"; break;
        case "p10":  $tipo="application/pkcs10"; break;
        case "p7c":  $tipo="application/pkcs7-mime"; break;
        case "p7m":  $tipo="application/pkcs7-mime"; break;
        case "p7s":  $tipo="application/pkcs7-signature"; break;
        case "cer":  $tipo="application/pkix-cert"; break;
        case "crt":  $tipo="application/pkix-cert"; break;
        case "crl":  $tipo="application/pkix-crl"; break;
        case "text":  $tipo="application/plain"; break;
        case "ai":  $tipo="application/postscript"; break;
        case "eps":  $tipo="application/postscript"; break;
        case "ps":  $tipo="application/postscript"; break;
        case "part":  $tipo="application/pro_eng"; break;
        case "prt":  $tipo="application/pro_eng"; break;
        case "rng":  $tipo="application/ringing-tones"; break;
        case "rtx":  $tipo="application/rtf"; break;
        case "sdp":  $tipo="application/sdp"; break;
        case "sea":  $tipo="application/sea"; break;
        case "set":  $tipo="application/set"; break;
        case "stl":  $tipo="application/sla"; break;
        case "smi":  $tipo="application/smil"; break;
        case "smil":  $tipo="application/smil"; break;
        case "sol":  $tipo="application/solids"; break;
        case "sdr":  $tipo="application/sounder"; break;
        case "step":  $tipo="application/step"; break;
        case "stp":  $tipo="application/step"; break;
        case "ssm":  $tipo="application/streamingmedia"; break;
        case "tbk":  $tipo="application/toolbook"; break;
        case "vda":  $tipo="application/vda"; break;
        case "fdf":  $tipo="application/vnd.fdf"; break;
        case "hgl":  $tipo="application/vnd.hp-hpgl"; break;
        case "hpg":  $tipo="application/vnd.hp-hpgl"; break;
        case "hpgl":  $tipo="application/vnd.hp-hpgl"; break;
        case "pcl":  $tipo="application/vnd.hp-pcl"; break;
        case "xla": $tipo= "application/vnd.ms-excel";break;
        case "xlb": $tipo= "application/vnd.ms-excel";break;
        case "xlc": $tipo= "application/vnd.ms-excel";break;
        case "xld": $tipo= "application/vnd.ms-excel";break;
        case "xlk": $tipo= "application/vnd.ms-excel";break;
        case "xll": $tipo= "application/vnd.ms-excel";break;
        case "xlm": $tipo= "application/vnd.ms-excel";break;
        case "xls": $tipo= "application/vnd.ms-excel";break;
        case "xlt": $tipo= "application/vnd.ms-excel";break;
        case "xlv": $tipo= "application/vnd.ms-excel";break;
        case "xlw": $tipo= "application/vnd.ms-excel";break;
        case "mif": $tipo= "application/vnd.ms-excel";break;
        case "xls": $tipo= "application/vnd.ms-excel";break;
        case "xlt": $tipo= "application/vnd.ms-excel";break;
        case "xlm": $tipo= "application/vnd.ms-excel";break;
        case "xld": $tipo= "application/vnd.ms-excel";break;
        case "xla": $tipo= "application/vnd.ms-excel";break;
        case "xlc": $tipo= "application/vnd.ms-excel";break;
        case "xlw": $tipo= "application/vnd.ms-excel";break;
        case "xll": $tipo= "application/vnd.ms-excel";break;
        case "xlsx":  $tipo= "application/vnd.ms-excel";break;
        case "sst":  $tipo="application/vnd.ms-pki.certstore"; break;
        case "pko":  $tipo="application/vnd.ms-pki.pko"; break;
        case "cat":  $tipo="application/vnd.ms-pki.seccat"; break;
        case "stl":  $tipo="application/vnd.ms-pki.stl"; break;
        case "pwz":  $tipo="application/vnd.ms-powerpoint"; break;
        case "mpp":  $tipo="application/vnd.ms-project"; break;
        case "ncm":  $tipo="application/vnd.nokia.configuration-message"; break;
        case "rng":  $tipo="application/vnd.nokia.ringing-tone"; break;
        case "rm":  $tipo="application/vnd.rn-realmedia"; break;
        case "rnx":  $tipo="application/vnd.rn-realplayer"; break;
        case "wmlc":  $tipo="application/vnd.wap.wmlc"; break;
        case "wmls":  $tipo="application/vnd.wap.wmlscriptc"; break;
        case "web":  $tipo="application/vnd.xara"; break;
        case "vmd":  $tipo="application/vocaltec-media-desc"; break;
        case "vmf":  $tipo="application/vocaltec-media-file"; break;
        case "wp":  $tipo="application/wordperfect"; break;
        case "wp5":  $tipo="application/wordperfect"; break;
        case "wp6":  $tipo="application/wordperfect"; break;
        case "wpd":  $tipo="application/wordperfect"; break;
        case "w60":  $tipo="application/wordperfect6.0"; break;
        case "wp5":  $tipo="application/wordperfect6.0"; break;
        case "w61":  $tipo="application/wordperfect6.1"; break;
        case "wk1":  $tipo="application/x-123"; break;
        case "aim":  $tipo="application/x-aim"; break;
        case "aab":  $tipo="application/x-authorware-bin"; break;
        case "aam":  $tipo="application/x-authorware-map"; break;
        case "aas":  $tipo="application/x-authorware-seg"; break;
        case "bcpi":  $tipo="application/x-bcpio"; break;
        case "bin":  $tipo="application/x-binary"; break;
        case "hqx":  $tipo="application/x-binhex40"; break;
        case "bsh":  $tipo="application/x-bsh"; break;
        case "sh":  $tipo="application/x-bsh"; break;
        case "shar":  $tipo="application/x-bsh"; break;
        case "elc":  $tipo="application/x-bytecode.elisp"; break;
        case "pyc":  $tipo="application/x-bytecode.python"; break;
        case "bz":  $tipo="application/x-bzip"; break;
        case "boz":  $tipo="application/x-bzip2"; break;
        case "bz2":  $tipo="application/x-bzip2"; break;
        case "cdf":  $tipo="application/x-cdf"; break;
        case "vcd":  $tipo="application/x-cdlink"; break;
        case "cha":  $tipo="application/x-chat"; break;
        case "chat":  $tipo="application/x-chat"; break;
        case "ras":  $tipo="application/x-cmu-raster"; break;
        case "cco":  $tipo="application/x-cocoa"; break;
        case "cpt":  $tipo="application/x-compactpro"; break;
        case "z":  $tipo="application/x-compress"; break;
        case "gz":  $tipo="application/x-compressed"; break;
        case "tgz":  $tipo="application/x-compressed"; break;
        case "z":  $tipo="application/x-compressed"; break;
        case "nsc":  $tipo="application/x-conference"; break;
        case "cpio":  $tipo="application/x-cpio"; break;
        case "cpt":  $tipo="application/x-cpt"; break;
        case "csh":  $tipo="application/x-csh"; break;
        case "deep":  $tipo="application/x-deepv"; break;
        case "dcr":  $tipo="application/x-director"; break;
        case "dir":  $tipo="application/x-director"; break;
        case "dxr":  $tipo="application/x-director"; break;
        case "dvi":  $tipo="application/x-dvi"; break;
        case "elc":  $tipo="application/x-elc"; break;
        case "env":  $tipo="application/x-envoy"; break;
        case "evy":  $tipo="application/x-envoy"; break;
        case "es":  $tipo="application/x-esrehber"; break;
        case "pre":  $tipo="application/x-freelance"; break;
        case "gsp":  $tipo="application/x-gsp"; break;
        case "gss":  $tipo="application/x-gss"; break;
        case "gtar":  $tipo="application/x-gtar"; break;
        case "gz":  $tipo="application/x-gzip"; break;
        case "gzip":  $tipo="application/x-gzip"; break;
        case "hdf":  $tipo="application/x-hdf"; break;
        case "help":  $tipo="application/x-helpfile"; break;
        case "hlp":  $tipo="application/x-helpfile"; break;
        case "imap":  $tipo="application/x-httpd-imap"; break;
        case "ima":  $tipo="application/x-ima"; break;
        case "ins":  $tipo="application/x-internett-signup"; break;
        case "iv":  $tipo="application/x-inventor"; break;
        case "ip":  $tipo="application/x-ip2"; break;
        case "clas":  $tipo="application/x-java-class"; break;
        case "jcm":  $tipo="application/x-java-commerce"; break;
        case "skd":  $tipo="application/x-koan"; break;
        case "skm":  $tipo="application/x-koan"; break;
        case "skp":  $tipo="application/x-koan"; break;
        case "skt":  $tipo="application/x-koan"; break;
        case "ksh":  $tipo="application/x-ksh"; break;
        case "late":  $tipo="application/x-latex"; break;
        case "ltx":  $tipo="application/x-latex"; break;
        case "lha":  $tipo="application/x-lha"; break;
        case "lsp":  $tipo="application/x-lisp"; break;
        case "ivy":  $tipo="application/x-livescreen"; break;
        case "wq1":  $tipo="application/x-lotus"; break;
        case "scm":  $tipo="application/x-lotusscreencam"; break;
        case "lzh":  $tipo="application/x-lzh"; break;
        case "lzx":  $tipo="application/x-lzx"; break;
        case "hqx":  $tipo="application/x-mac-binhex40"; break;
        case "bin":  $tipo="application/x-macbinary"; break;
        case "mc$":  $tipo="application/x-magic-cap-package-1.0"; break;
        case "mcd":  $tipo="application/x-mathcad"; break;
        case "mm":  $tipo="application/x-meme"; break;
        case "mid":  $tipo="application/x-midi"; break;
        case "midi":  $tipo="application/x-midi"; break;
        case "mif":  $tipo="application/x-mif"; break;
        case "nix":  $tipo="application/x-mix-transfer"; break;
        case "asx":  $tipo="application/x-mplayer2"; break;
        case "xla":  $tipo="application/x-msexcel"; break;
        case "xls":  $tipo="application/x-msexcel"; break;
        case "xlw":  $tipo="application/x-msexcel"; break;
        case "ani":  $tipo="application/x-navi-animation"; break;
        case "nvd":  $tipo="application/x-navidoc"; break;
        case "map":  $tipo="application/x-navimap"; break;
        case "stl":  $tipo="application/x-navistyle"; break;
        case "cdf":  $tipo="application/x-netcdf"; break;
        case "nc":  $tipo="application/x-netcdf"; break;
        case "pkg":  $tipo="application/x-newton-compatible-pkg"; break;
        case "aos":  $tipo="application/x-nokia-9000-communicator-add-on-softw"; break;
        case "omc":  $tipo="application/x-omc"; break;
        case "omcd":  $tipo="application/x-omcdatamaker"; break;
        case "omcr":  $tipo="application/x-omcregerator"; break;
        case "pm4":  $tipo="application/x-pagemaker"; break;
        case "pm5":  $tipo="application/x-pagemaker"; break;
        case "pcl":  $tipo="application/x-pcl"; break;
        case "plx":  $tipo="application/x-pixclscript"; break;
        case "p10":  $tipo="application/x-pkcs10"; break;
        case "p12":  $tipo="application/x-pkcs12"; break;
        case "spc":  $tipo="application/x-pkcs7-certificates"; break;
        case "p7r":  $tipo="application/x-pkcs7-certreqresp"; break;
        case "p7c":  $tipo="application/x-pkcs7-mime"; break;
        case "p7m":  $tipo="application/x-pkcs7-mime"; break;
        case "p7a":  $tipo="application/x-pkcs7-signature"; break;
        case "pnm":  $tipo="application/x-portable-anymap"; break;
        case "mpc":  $tipo="application/x-project"; break;
        case "mpt":  $tipo="application/x-project"; break;
        case "mpv":  $tipo="application/x-project"; break;
        case "mpx":  $tipo="application/x-project"; break;
        case "wb1":  $tipo="application/x-qpro"; break;
        case "sdp":  $tipo="application/x-sdp"; break;
        case "sea":  $tipo="application/x-sea"; break;
        case "sl":  $tipo="application/x-seelogo"; break;
        case "sh":  $tipo="application/x-sh"; break;
        case "sh":  $tipo="application/x-shar"; break;
        case "shar":  $tipo="application/x-shar"; break;
        case "sit":  $tipo="application/x-sit"; break;
        case "spr":  $tipo="application/x-sprite"; break;
        case "spri":  $tipo="application/x-sprite"; break;
        case "sit":  $tipo="application/x-stuffit"; break;
        case "sv4c":  $tipo="application/x-sv4cpio"; break;
        case "sv4c":  $tipo="application/x-sv4crc"; break;
        case "sbk":  $tipo="application/x-tbook"; break;
        case "tbk":  $tipo="application/x-tbook"; break;
        case "tcl":  $tipo="application/x-tcl"; break;
        case "tex":  $tipo="application/x-tex"; break;
        case "texi":  $tipo="application/x-texinfo"; break;
        case "roff":  $tipo="application/x-troff"; break;
        case "t":  $tipo="application/x-troff"; break;
        case "tr":  $tipo="application/x-troff"; break;
        case "man":  $tipo="application/x-troff-man"; break;
        case "me":  $tipo="application/x-troff-me"; break;
        case "ms":  $tipo="application/x-troff-ms"; break;
        case "usta":  $tipo="application/x-ustar"; break;
        case "vsd":  $tipo="application/x-visio"; break;
        case "vst":  $tipo="application/x-visio"; break;
        case "vsw":  $tipo="application/x-visio"; break;
        case "mzz":  $tipo="application/x-vnd.audioexplosion.mzz"; break;
        case "xpix":  $tipo="application/x-vnd.ls-xpix"; break;
        case "vrml":  $tipo="application/x-vrml"; break;
        case "src":  $tipo="application/x-wais-source"; break;
        case "wsrc":  $tipo="application/x-wais-source"; break;
        case "hlp":  $tipo="application/x-winhelp"; break;
        case "wtk":  $tipo="application/x-wintalk"; break;
        case "svr":  $tipo="application/x-world"; break;
        case "wrl":  $tipo="application/x-world"; break;
        case "wpd":  $tipo="application/x-wpwin"; break;
        case "wri":  $tipo="application/x-wri"; break;
        case "cer":  $tipo="application/x-x509-ca-cert"; break;
        case "crt":  $tipo="application/x-x509-ca-cert"; break;
        case "der":  $tipo="application/x-x509-ca-cert"; break;
        case "crt":  $tipo="application/x-x509-user-cert"; break;
        case "xml":  $tipo="application/xml"; break;
        case "aifc":  $tipo="audio/aiff"; break;
        case "au":  $tipo="audio/basic"; break;
        case "snd":  $tipo="audio/basic"; break;
        case "it":  $tipo="audio/it"; break;
        case "funk":  $tipo="audio/make"; break;
        case "my":  $tipo="audio/make"; break;
        case "pfun":  $tipo="audio/make"; break;
        case "pfun":  $tipo="audio/make.my.funk"; break;
        case "rmi":  $tipo="audio/mid"; break;
        case "kar":  $tipo="audio/midi"; break;
        case "mid":  $tipo="audio/midi"; break;
        case "midi":  $tipo="audio/midi"; break;
        case "mod":  $tipo="audio/mod"; break;
        case "m2a":  $tipo="audio/mpeg"; break;
        case "mp2":  $tipo="audio/mpeg"; break;
        case "mpa":  $tipo="audio/mpeg"; break;
        case "mpga":  $tipo="audio/mpeg"; break;
        case "la":  $tipo="audio/nspaudio"; break;
        case "lma":  $tipo="audio/nspaudio"; break;
        case "s3m":  $tipo="audio/s3m"; break;
        case "tsi":  $tipo="audio/tsp-audio"; break;
        case "tsp":  $tipo="audio/tsplayer"; break;
        case "qcp":  $tipo="audio/vnd.qcelp"; break;
        case "voc":  $tipo="audio/voc"; break;
        case "vox":  $tipo="audio/voxware"; break;
        case "snd":  $tipo="audio/x-adpcm"; break;
        case "aifc":  $tipo="audio/x-aiff"; break;
        case "au":  $tipo="audio/x-au"; break;
        case "gsd":  $tipo="audio/x-gsm"; break;
        case "gsm":  $tipo="audio/x-gsm"; break;
        case "jam":  $tipo="audio/x-jam"; break;
        case "lam":  $tipo="audio/x-liveaudio"; break;
        case "mid":  $tipo="audio/x-mid"; break;
        case "midi":  $tipo="audio/x-mid"; break;
        case "mid":  $tipo="audio/x-midi"; break;
        case "midi":  $tipo="audio/x-midi"; break;
        case "mod":  $tipo="audio/x-mod"; break;
        case "mp2":  $tipo="audio/x-mpeg"; break;
        case "m3u":  $tipo="audio/x-mpequrl"; break;
        case "la":  $tipo="audio/x-nspaudio"; break;
        case "lma":  $tipo="audio/x-nspaudio"; break;
        case "ra":  $tipo="audio/x-pn-realaudio"; break;
        case "ram":  $tipo="audio/x-pn-realaudio"; break;
        case "rm":  $tipo="audio/x-pn-realaudio"; break;
        case "rmm":  $tipo="audio/x-pn-realaudio"; break;
        case "rmp":  $tipo="audio/x-pn-realaudio"; break;
        case "ra":  $tipo="audio/x-pn-realaudio-plugin"; break;
        case "rmp":  $tipo="audio/x-pn-realaudio-plugin"; break;
        case "rpm":  $tipo="audio/x-pn-realaudio-plugin"; break;
        case "sid":  $tipo="audio/x-psid"; break;
        case "ra":  $tipo="audio/x-realaudio"; break;
        case "vqf":  $tipo="audio/x-twinvq"; break;
        case "vqe":  $tipo="audio/x-twinvq-plugin"; break;
        case "vql":  $tipo="audio/x-twinvq-plugin"; break;
        case "mjf":  $tipo="audio/x-vnd.audioexplosion.mjuicemediafile"; break;
        case "voc":  $tipo="audio/x-voc"; break;
        case "xm":  $tipo="audio/xm"; break;
        case "pdb":  $tipo="chemical/x-pdb"; break;
        case "xyz":  $tipo="chemical/x-pdb"; break;
        case "dwf":  $tipo="drawing/x-dwf"; break;
        case "ivr":  $tipo="i-world/i-vrml"; break;
        case "bm":  $tipo="image/bmp"; break;
        case "bmp":  $tipo="image/bmp"; break;
        case "ras":  $tipo="image/cmu-raster"; break;
        case "rast":  $tipo="image/cmu-raster"; break;
        case "fif":  $tipo="image/fif"; break;
        case "flo":  $tipo="image/florian"; break;
        case "turb":  $tipo="image/florian"; break;
        case "g3":  $tipo="image/g3fax"; break;
        case "gif":  $tipo="image/gif"; break;
        case "ief":  $tipo="image/ief"; break;
        case "iefs":  $tipo="image/ief"; break;
        case "jfif":  $tipo="image/jpeg"; break;
        case "jpe":  $tipo="image/jpeg"; break;
        case "jpeg":  $tipo="image/jpeg"; break;
        case "jpg":  $tipo="image/jpeg"; break;
        case "jut":  $tipo="image/jutvision"; break;
        case "nap":  $tipo="image/naplps"; break;
        case "napl":  $tipo="image/naplps"; break;
        case "pic":  $tipo="image/pict"; break;
        case "pict":  $tipo="image/pict"; break;
        case "jfif":  $tipo="image/pjpeg"; break;
        case "jpe":  $tipo="image/pjpeg"; break;
        case "jpeg":  $tipo="image/pjpeg"; break;
        case "jpg":  $tipo="image/pjpeg"; break;
        case "png":  $tipo="image/png"; break;
        case "x-pn":  $tipo="image/png"; break;
        case "tif":  $tipo="image/tiff"; break;
        case "tiff":  $tipo="image/tiff"; break;
        case "mcf":  $tipo="image/vasa"; break;
        case "dxf":  $tipo="image/vnd.dwg"; break;
        case "svf":  $tipo="image/vnd.dwg"; break;
        case "fpx":  $tipo="image/vnd.fpx"; break;
        case "fpx":  $tipo="image/vnd.net-fpx"; break;
        case "rf":  $tipo="image/vnd.rn-realflash"; break;
        case "rp":  $tipo="image/vnd.rn-realpix"; break;
        case "wbmp":  $tipo="image/vnd.wap.wbmp"; break;
        case "xif":  $tipo="image/vnd.xiff"; break;
        case "ras":  $tipo="image/x-cmu-raster"; break;
        case "dxf":  $tipo="image/x-dwg"; break;
        case "svf":  $tipo="image/x-dwg"; break;
        case "ico":  $tipo="image/x-icon"; break;
        case "art":  $tipo="image/x-jg"; break;
        case "jps":  $tipo="image/x-jps"; break;
        case "nif":  $tipo="image/x-niff"; break;
        case "niff":  $tipo="image/x-niff"; break;
        case "pcx":  $tipo="image/x-pcx"; break;
        case "pct":  $tipo="image/x-pict"; break;
        case "pnm":  $tipo="image/x-portable-anymap"; break;
        case "pbm":  $tipo="image/x-portable-bitmap"; break;
        case "pgm":  $tipo="image/x-portable-graymap"; break;
        case "pgm":  $tipo="image/x-portable-greymap"; break;
        case "ppm":  $tipo="image/x-portable-pixmap"; break;
        case "qif":  $tipo="image/x-quicktime"; break;
        case "qti":  $tipo="image/x-quicktime"; break;
        case "qtif":  $tipo="image/x-quicktime"; break;
        case "rgb":  $tipo="image/x-rgb"; break;
        case "tif":  $tipo="image/x-tiff"; break;
        case "tiff":  $tipo="image/x-tiff"; break;
        case "bmp":  $tipo="image/x-windows-bmp"; break;
        case "xbm":  $tipo="image/x-xbitmap"; break;
        case "xbm":  $tipo="image/x-xbm"; break;
        case "pm":  $tipo="image/x-xpixmap"; break;
        case "xpm":  $tipo="image/x-xpixmap"; break;
        case "xwd":  $tipo="image/x-xwd"; break;
        case "xwd":  $tipo="image/x-xwindowdump"; break;
        case "xbm":  $tipo="image/xbm"; break;
        case "xpm":  $tipo="image/xpm"; break;
        case "mht":  $tipo="message/rfc822"; break;
        case "mhtm":  $tipo="message/rfc822"; break;
        case "mime":  $tipo="message/rfc822"; break;
        case "iges":  $tipo="model/iges"; break;
        case "igs":  $tipo="model/iges"; break;
        case "dwf":  $tipo="model/vnd.dwf"; break;
        case "vrml":  $tipo="model/vrml"; break;
        case "wrl":  $tipo="model/vrml"; break;
        case "wrz":  $tipo="model/vrml"; break;
        case "pov":  $tipo="model/x-pov"; break;
        case "gzip":  $tipo="multipart/x-gzip"; break;
        case "usta":  $tipo="multipart/x-ustar"; break;
        case "mid":  $tipo="music/crescendo"; break;
        case "midi":  $tipo="music/crescendo"; break;
        case "kar":  $tipo="music/x-karaoke"; break;
        case "pvu":  $tipo="paleovu/x-pv"; break;
        case "asp":  $tipo="text/asp"; break;
        case "css":  $tipo="text/css"; break;
        case "acgi":  $tipo="text/html"; break;
        case "htm":  $tipo="text/html"; break;
        case "html":  $tipo="text/html"; break;
        case "htx":  $tipo="text/html"; break;
        case "shtm":  $tipo="text/html"; break;
        case "mcf":  $tipo="text/mcf"; break;
        case "pas":  $tipo="text/pascal"; break;
        case "c":  $tipo="text/plain"; break;
        case "c++":  $tipo="text/plain"; break;
        case "cc":  $tipo="text/plain"; break;
        case "com":  $tipo="text/plain"; break;
        case "conf":  $tipo="text/plain"; break;
        case "cxx":  $tipo="text/plain"; break;
        case "def":  $tipo="text/plain"; break;
        case "f":  $tipo="text/plain"; break;
        case "f90":  $tipo="text/plain"; break;
        case "for":  $tipo="text/plain"; break;
        case "g":  $tipo="text/plain"; break;
        case "h":  $tipo="text/plain"; break;
        case "hh":  $tipo="text/plain"; break;
        case "idc":  $tipo="text/plain"; break;
        case "jav":  $tipo="text/plain"; break;
        case "java":  $tipo="text/plain"; break;
        case "list":  $tipo="text/plain"; break;
        case "log":  $tipo="text/plain"; break;
        case "lst":  $tipo="text/plain"; break;
        case "m":  $tipo="text/plain"; break;
        case "mar":  $tipo="text/plain"; break;
        case "pl":  $tipo="text/plain"; break;
        case "sdml":  $tipo="text/plain"; break;
        case "text":  $tipo="text/plain"; break;
        case "txt":  $tipo="text/plain"; break;
        case "rt":  $tipo="text/richtext"; break;
        case "rtx":  $tipo="text/richtext"; break;
        case "wsc":  $tipo="text/scriplet"; break;
        case "sgm":  $tipo="text/sgml"; break;
        case "sgml":  $tipo="text/sgml"; break;
        case "tsv":  $tipo="text/tab-separated-values"; break;
        case "uni":  $tipo="text/uri-list"; break;
        case "unis":  $tipo="text/uri-list"; break;
        case "uri":  $tipo="text/uri-list"; break;
        case "uris":  $tipo="text/uri-list"; break;
        case "abc":  $tipo="text/vnd.abc"; break;
        case "flx":  $tipo="text/vnd.fmi.flexstor"; break;
        case "rt":  $tipo="text/vnd.rn-realtext"; break;
        case "wml":  $tipo="text/vnd.wap.wml"; break;
        case "wmls":  $tipo="text/vnd.wap.wmlscript"; break;
        case "htt":  $tipo="text/webviewhtml"; break;
        case "asm":  $tipo="text/x-asm"; break;
        case "s":  $tipo="text/x-asm"; break;
        case "aip":  $tipo="text/x-audiosoft-intra"; break;
        case "c":  $tipo="text/x-c"; break;
        case "cc":  $tipo="text/x-c"; break;
        case "cpp":  $tipo="text/x-c"; break;
        case "htc":  $tipo="text/x-component"; break;
        case "f":  $tipo="text/x-fortran"; break;
        case "f77":  $tipo="text/x-fortran"; break;
        case "f90":  $tipo="text/x-fortran"; break;
        case "for":  $tipo="text/x-fortran"; break;
        case "h":  $tipo="text/x-h"; break;
        case "hh":  $tipo="text/x-h"; break;
        case "jav":  $tipo="text/x-java-source"; break;
        case "java":  $tipo="text/x-java-source"; break;
        case "lsx":  $tipo="text/x-la-asf"; break;
        case "m":  $tipo="text/x-m"; break;
        case "p":  $tipo="text/x-pascal"; break;
        case "hlb":  $tipo="text/x-script"; break;
        case "csh":  $tipo="text/x-script.csh"; break;
        case "el":  $tipo="text/x-script.elisp"; break;
        case "scm":  $tipo="text/x-script.guile"; break;
        case "ksh":  $tipo="text/x-script.ksh"; break;
        case "lsp":  $tipo="text/x-script.lisp"; break;
        case "pl":  $tipo="text/x-script.perl"; break;
        case "pm":  $tipo="text/x-script.perl-module"; break;
        case "py":  $tipo="text/x-script.phyton"; break;
        case "rexx":  $tipo="text/x-script.rexx"; break;
        case "scm":  $tipo="text/x-script.scheme"; break;
        case "sh":  $tipo="text/x-script.sh"; break;
        case "tcl":  $tipo="text/x-script.tcl"; break;
        case "tcsh":  $tipo="text/x-script.tcsh"; break;
        case "zsh":  $tipo="text/x-script.zsh"; break;
        case "shtm":  $tipo="text/x-server-parsed-html"; break;
        case "ssi":  $tipo="text/x-server-parsed-html"; break;
        case "etx":  $tipo="text/x-setext"; break;
        case "sgm":  $tipo="text/x-sgml"; break;
        case "sgml":  $tipo="text/x-sgml"; break;
        case "spc":  $tipo="text/x-speech"; break;
        case "talk":  $tipo="text/x-speech"; break;
        case "uil":  $tipo="text/x-uil"; break;
        case "uu":  $tipo="text/x-uuencode"; break;
        case "uue":  $tipo="text/x-uuencode"; break;
        case "vcs":  $tipo="text/x-vcalendar"; break;
        case "xml":  $tipo="text/xml"; break;
        case "afl":  $tipo="video/animaflex"; break;
        case "avs":  $tipo="video/avs-video"; break;
        case "dl":  $tipo="video/dl"; break;
        case "fli":  $tipo="video/fli"; break;
        case "gl":  $tipo="video/gl"; break;
        case "m1v":  $tipo="video/mpeg"; break;
        case "m2v":  $tipo="video/mpeg"; break;
        case "mp2":  $tipo="video/mpeg"; break;
        case "mpa":  $tipo="video/mpeg"; break;
        case "mpg":  $tipo="video/mpeg"; break;
        case "moov":  $tipo="video/quicktime"; break;
        case "qt":  $tipo="video/quicktime"; break;
        case "vdo":  $tipo="video/vdo"; break;
        case "viv":  $tipo="video/vivo"; break;
        case "vivo":  $tipo="video/vivo"; break;
        case "rv":  $tipo="video/vnd.rn-realvideo"; break;
        case "viv":  $tipo="video/vnd.vivo"; break;
        case "vivo":  $tipo="video/vnd.vivo"; break;
        case "vos":  $tipo="video/vosaic"; break;
        case "xdr":  $tipo="video/x-amt-demorun"; break;
        case "xsr":  $tipo="video/x-amt-showrun"; break;
        case "fmf":  $tipo="video/x-atomic3d-feature"; break;
        case "dl":  $tipo="video/x-dl"; break;
        case "dif":  $tipo="video/x-dv"; break;
        case "dv":  $tipo="video/x-dv"; break;
        case "fli":  $tipo="video/x-fli"; break;
        case "gl":  $tipo="video/x-gl"; break;
        case "isu":  $tipo="video/x-isvideo"; break;
        case "mjpg":  $tipo="video/x-motion-jpeg"; break;
        case "mp2":  $tipo="video/x-mpeg"; break;
        case "mp2":  $tipo="video/x-mpeq2a"; break;
        case "asf":  $tipo="video/x-ms-asf"; break;
        case "asx":  $tipo="video/x-ms-asf"; break;
        case "asx":  $tipo="video/x-ms-asf-plugin"; break;
        case "qtc":  $tipo="video/x-qtc"; break;
        case "scm":  $tipo="video/x-scm"; break;
        case "movi":  $tipo="video/x-sgi-movie"; break;
        case "mv":  $tipo="video/x-sgi-movie"; break;
        case "wmf":  $tipo="windows/metafile"; break;
        case "mime":  $tipo="www/mime"; break;
        case "ice":  $tipo="x-conference/x-cooltalk"; break;
        case "mid":  $tipo="x-music/x-midi"; break;
        case "midi":  $tipo="x-music/x-midi"; break;
        case "3dm":  $tipo="x-world/x-3dmf"; break;
        case "3dmf":  $tipo="x-world/x-3dmf"; break;
        case "qd3":  $tipo="x-world/x-3dmf"; break;
        case "qd3d":  $tipo="x-world/x-3dmf"; break;
        case "svr":  $tipo="x-world/x-svr"; break;
        case "vrml":  $tipo="x-world/x-vrml"; break;
        case "wrl":  $tipo="x-world/x-vrml"; break;
        case "wrz":  $tipo="x-world/x-vrml"; break;
        case "vrt":  $tipo="x-world/x-vrt"; break;
        case "xgz":  $tipo="xgl/drawing"; break;
        case "xmz":  $tipo="xgl/movie"; break;
        case "csv":  $tipo="text/csv"; break;
        default:
            $tipo=mime_content_type($file);
    }
    return $tipo;
}
}
?>