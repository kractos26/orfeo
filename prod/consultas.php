<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
</head>
<body>
<? 
   include_once "./include/db/ConnectionHandler.php";
	$db = new ConnectionHandler(".");
	error_reporting(7);   
   $isql = "Select * from  usuario where usua_login like '%JH%'";
   $pager = new ADODB_Pager($db->conn,$isql,'adodb', true,$orderNo,$orderTipo);
   $pager->toRefLinks = $linkPagina;
   $pager->Render($rows_per_page=75,$linkPagina,$checkbox=chkAnulados);

?>
</body>
</html>
