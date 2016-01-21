<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=expexcel.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $_POST['datos'];
?>
