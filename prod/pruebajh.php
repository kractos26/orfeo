<html>
<head>
<title>Untitled Document</title>
</head>
<body>
<?
   include_once "./include/db/ConnectionHandler.php";
   $db = new ConnectionHandler(".");	 
	$db->conn->debug = true;
	$sql = "select * from radicado";
	$pager = new ADODB_Pager($db->conn,$sql,'adodb', true,1,"");
	$pager->toRefLinks = $linkPagina;
	$pager->toRefVars = $encabezado;
	$pager->Render($rows_per_page=10,$linkPagina,$checkbox=chkAnulados);
	
?>
</body>
</html>
